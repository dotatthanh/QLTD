<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'code',
        'power_number',
        'price',
        'proceeds',
        'amount_return',
        'period',
        'debit',
        'status',
    ];

    const UNPAID = 0;
    const PAID = 1;

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
