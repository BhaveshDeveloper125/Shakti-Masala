<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'image',
        'name',
        'brand_name',
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
    ];
}
