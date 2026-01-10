<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Koperasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subscriptionPackage()
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }
}
