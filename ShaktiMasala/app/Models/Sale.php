<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $table = 'sales';

    protected $fillable = [
        'customer_id',
        'name',
        'brand',
        'mrp',
        'total_packet',
        'price_per_carot',
        'packaging_type',
        'net_weight',
        'net_per_unit',
        'units_per_carton',
        'batch',
        'mfg_date',
        'exp_date',
        'payable_amount',
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->payable_amount = $model->total_packet * $model->price_per_carot;
        });
    }

    public function Customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}
