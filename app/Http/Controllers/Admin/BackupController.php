<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk('local');
        $backupName = config('backup.backup.name');
        
        // Ensure directory exists
        if (!$disk->exists($backupName)) {
            $disk->makeDirectory($backupName);
        }

        $files = $disk->files($backupName);
        $backups = [];

        foreach ($files as $k => $f) {
            // Only take .zip files
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace($backupName . '/', '', $f),
                    'file_size' => $this->humanFileSize($disk->size($f)),
                    'last_modified' => Carbon::createFromTimestamp($disk->lastModified($f))->diffForHumans(),
                    'created_at' => $disk->lastModified($f), // for sorting
                ];
            }
        }

        // Sort by newest
        $backups = array_reverse(array_values(collect($backups)->sortBy('created_at')->toArray()));
        
        // Debug info (optional, remove later)
        // dump($disk->path($backupName));

        return view('admin.backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            set_time_limit(300); // 5 minutes

            // Ensure destination folder exists
            $disk = Storage::disk('local');
            $backupName = config('backup.backup.name');
             if (!$disk->exists($backupName)) {
                $disk->makeDirectory($backupName);
            }

            Artisan::call('backup:run --only-db --disable-notifications');
            $output = Artisan::output();

            // Check if output contains "Failed"
            if (strpos($output, 'Backup failed') !== false) {
                 throw new \Exception("Backup command reported failure: " . $output);
            }

            return redirect()->back()->with('success', 'Backup Database berhasil dibuat. Output: ' . substr($output, 0, 100));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Backup Failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download($file_name)
    {
        $backupName = config('backup.backup.name');
        $file = $backupName . '/' . $file_name;
        $disk = Storage::disk('local');

        if ($disk->exists($file)) {
            // storage_path('app/private') is the root of local disk
            return response()->download(storage_path('app/private/' . $file));
        }

        return redirect()->back()->with('error', 'File backup tidak ditemukan.');
    }

    public function restore($file_name)
    {
        try {
            set_time_limit(300); // 5 minutes

            $backupName = config('backup.backup.name');
            $filePath = $backupName . '/' . $file_name;
            $disk = Storage::disk('local');

            if (!$disk->exists($filePath)) {
                return redirect()->back()->with('error', 'File backup tidak ditemukan.');
            }

            $fullPath = storage_path('app/private/' . $filePath);
            
            // 1. Extract ZIP
            $zip = new \ZipArchive;
            if ($zip->open($fullPath) === TRUE) {
                // Extract to a temporary folder
                $tempExtractDir = storage_path('app/temp_restore_' . time());
                if (!file_exists($tempExtractDir)) {
                    mkdir($tempExtractDir, 0777, true);
                }
                
                $zip->extractTo($tempExtractDir);
                $zip->close();
                
                // 2. Find SQL File
                // Usually it's in 'db-dumps/mysql-db_koperasi.sql' or similar structure inside zip
                $sqlFile = null;
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($tempExtractDir));
                foreach ($files as $file) {
                    if ($file->getExtension() === 'sql') {
                        $sqlFile = $file->getRealPath();
                        break;
                    }
                }

                if (!$sqlFile) {
                    // Cleanup
                    \Illuminate\Support\Facades\File::deleteDirectory($tempExtractDir);
                    return redirect()->back()->with('error', 'File SQL tidak ditemukan dalam backup.');
                }

                // 3. Import Database
                $dbUser = config('database.connections.mysql.username');
                $dbPass = config('database.connections.mysql.password');
                $dbName = config('database.connections.mysql.database');
                $dbHost = config('database.connections.mysql.host');
                $dbPort = config('database.connections.mysql.port');

                // Determine mysql binary path
                if (PHP_OS_FAMILY === 'Windows') {
                    // Use Laragon's MySQL
                    $mysqlBin = "D:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql.exe"; 
                } else {
                    $mysqlBin = 'mysql';
                }

                // Construct Command
                // mysql -u [user] -p[password] [database_name] < [input_file]
                // Note: No space between -p and password
                $passwordArg = $dbPass ? "-p\"$dbPass\"" : "";
                
                $command = "\"$mysqlBin\" --host=$dbHost --port=$dbPort --user=$dbUser $passwordArg $dbName < \"$sqlFile\" 2>&1";

                $output = [];
                $returnVar = 0;
                exec($command, $output, $returnVar);

                // Cleanup Temp Files immediately
                \Illuminate\Support\Facades\File::deleteDirectory($tempExtractDir);

                if ($returnVar !== 0) {
                    $errorOutput = implode("\n", $output);
                    throw new \Exception("Restore process failed. Output: $errorOutput");
                }

                return redirect()->back()->with('success', 'Database berhasil dipulihkan (Restore Success).');

            } else {
                return redirect()->back()->with('error', 'Gagal membuka file backup (ZIP Error).');
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Restore Failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal restore: ' . $e->getMessage());
        }
    }

    public function destroy($file_name)
    {
        $backupName = config('backup.backup.name');
        $file = $backupName . '/' . $file_name;
        $disk = Storage::disk('local');

        if ($disk->exists($file)) {
            $disk->delete($file);
            return redirect()->back()->with('success', 'Backup berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'File backup tidak ditemukan.');
    }

    private function humanFileSize($size, $unit = "") {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)." GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)." MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)." KB";
        return number_format($size)." bytes";
    }
}
