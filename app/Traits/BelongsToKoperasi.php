<?php

namespace App\Traits;

use App\Models\Koperasi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToKoperasi
{
    protected static function bootBelongsToKoperasi()
    {
        static::addGlobalScope('koperasi', function (Builder $builder) {
            // Use hasUser() instead of check() to avoid infinite loop when User model itself is being queried during Auth
            if (Auth::hasUser()) {
                if (Auth::user()->koperasi_id) {
                    $builder->where('koperasi_id', Auth::user()->koperasi_id);
                } else {
                    // Super Admin (koperasi_id is null)
                    // ... (Logic remains same)
                    $builder->whereNull('koperasi_id'); 
                }
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                // If user has koperasi_id (Tenant Admin), force it
                if (Auth::user()->koperasi_id) {
                    $model->koperasi_id = Auth::user()->koperasi_id;
                }
                // If user is Super Admin (no koperasi_id), allow manual assignment
                // Code in controller: User::create(['koperasi_id' => $id, ...])
                // So we don't need to do anything here if it's already set.
            }
        });
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
