<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }

    public function members()
    {
        return $this->hasMany(ShuMember::class, 'shu_id');
    }
}
