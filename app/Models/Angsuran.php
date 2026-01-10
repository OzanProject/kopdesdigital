<?php

namespace App\Models;

use App\Traits\BelongsToKoperasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory, BelongsToKoperasi;

    protected $guarded = ['id'];

    protected $casts = [
        'jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
