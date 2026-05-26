<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'amount',
        'status',
        'processed_at',
        'remarks',
        'idempotency_key'
    ];

    // protected $casts = [
    //     'processed_at' => 'datetime'
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
