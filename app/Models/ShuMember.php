<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShuMember extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function shu()
    {
        return $this->belongsTo(Shu::class);
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
