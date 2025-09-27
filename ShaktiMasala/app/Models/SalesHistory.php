<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesHistory extends Model
{
    protected $table = 'sales_histories';
    protected $fillable = [
        'customers_id',
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

    public function Customers()
    {
        return $this->belongsTo(Customers::class);
    }
}
