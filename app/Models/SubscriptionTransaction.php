<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionTransaction extends Model
{
    protected $fillable = [
        'koperasi_id',
        'subscription_package_id',
        'order_id',
        'amount',
        'snap_token',
        'status',
        'notes',
        'discount_id',
        'discount_code',
        'discount_amount',
        'payment_type',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }

    public function package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id');
    }
}
