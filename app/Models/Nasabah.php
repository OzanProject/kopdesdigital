<?php

namespace App\Models;

use App\Traits\BelongsToKoperasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory, BelongsToKoperasi;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    // Helper to generate next member number
    public static function generateNoAnggota($koperasiId)
    {
        $lastMember = self::where('koperasi_id', $koperasiId)->latest('id')->first();
        if (!$lastMember) {
            return 'ANG-0001';
        }
        
        $number = intval(substr($lastMember->no_anggota, 4)) + 1;
        return 'ANG-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
    public function simpanans()
    {
        return $this->hasMany(Simpanan::class);
    }

    public function getSaldoSukarelaAttribute()
    {
        $totalSimpananSukarela = $this->simpanans()->where('jenis', 'sukarela')->sum('jumlah');
        $totalPenarikan = $this->penarikans()->sum('jumlah'); // Assuming relationship added
        
        return $totalSimpananSukarela - $totalPenarikan;
    }

    public function penarikans()
    {
        return $this->hasMany(Penarikan::class);
    }

    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
