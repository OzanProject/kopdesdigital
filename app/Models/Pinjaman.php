<?php

namespace App\Models;

use App\Traits\BelongsToKoperasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory, BelongsToKoperasi;

    protected $table = 'pinjamans';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'date',
        'jumlah_pengajuan' => 'decimal:2',
        'jumlah_disetujui' => 'decimal:2',
        'bunga_persen' => 'decimal:2',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function angsurans()
    {
        return $this->hasMany(Angsuran::class);
    }

    public static function generateKode($koperasiId)
    {
        $prefix = 'PINJ-' . date('Ymd') . '-';
        $last = self::where('koperasi_id', $koperasiId)
                    ->where('kode_pinjaman', 'like', $prefix . '%')
                    ->latest('id')
                    ->first();

        if (!$last) {
            return $prefix . '001';
        }

        $number = intval(substr($last->kode_pinjaman, -3)) + 1;
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
