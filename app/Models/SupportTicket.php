<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'koperasi_id',
        'user_id',
        'subject',
        'priority',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }
}
