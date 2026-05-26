<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'available_balance',
        'locked_balance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
