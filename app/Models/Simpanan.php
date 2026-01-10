<?php

namespace App\Models;

use App\Traits\BelongsToKoperasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory, BelongsToKoperasi;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
