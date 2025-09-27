<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customers extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'invoice',
        'customer_name',
        'customer_type',
        'date',
        'payment_mode',
        'payment_status',
        'partial_amount',
        'extra_charges',
        'total_price'
    ];

    public function Sale()
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }

    public function SalesHistory()
    {
        return $this->hasMany(SalesHistory::class, 'customer_id', 'id');
    }
}
