<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions'; // Pastikan tabel sesuai dengan database

    protected $fillable = [
        'order_id', 'user_id', 'total_price', 'transaction_status', 'payment_type'
    ];
}