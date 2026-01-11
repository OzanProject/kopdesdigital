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
    public function getJumlahPinjamanAttribute()
    {
        return $this->jumlah_pengajuan;
    }

    public function getTotalJumlahAttribute()
    {
        // If approved, calculate based on installments sum effectively
        if ($this->status == 'approved' || $this->status == 'lunas') {
             // Prefer summing actual installments if they exist
             $sum = $this->angsurans->sum('jumlah_bayar');
             if ($sum > 0) return $sum;

             // Fallback calculation
             $bunga = $this->jumlah_disetujui * ($this->bunga_persen / 100) * $this->tenor_bulan;
             return $this->jumlah_disetujui + $bunga;
        }
        return $this->jumlah_pengajuan;
    }

    public function getSisaTagihanAttribute()
    {
        if ($this->status == 'lunas') return 0;
        if ($this->status == 'approved') {
             $total = $this->total_jumlah;
             $paid = $this->angsurans->where('status', 'paid')->sum('jumlah_bayar');
             return max(0, $total - $paid);
        }
        return $this->jumlah_pengajuan; // Or 0 for pending? Usually pending shows requested amount.
    }
}
