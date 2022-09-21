<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'response',
        'payment_id',
        'payment_date',
    ];
}
