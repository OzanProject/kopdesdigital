<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'max_users',
        'max_members',
        'description',
        'is_active',
    ];

    public function koperasis()
    {
        return $this->hasMany(Koperasi::class);
    }
}
