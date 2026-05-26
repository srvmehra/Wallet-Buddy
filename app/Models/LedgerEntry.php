<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    protected $fillable = [
        'user_id',
        'entry_type',
        'activity',
        'amount',
        'balance_before',
        'balance_after',
        'reference_type',
        'reference_id',
        'payment_type',
        'payment_mode',
        'transaction_reference',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
