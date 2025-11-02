<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCosting extends Model
{
    protected $table = 'product_costings';
    protected $fillable = [
        'product_id',
        'raw_material',
        'labour',
        'other_expense',
        'product_type',
        'total_unit_produced',
        'price_per_unit',
    ];

    protected static function boot()
    {
        static::creating(function ($model) {
            $model->price_per_unit = $model->raw_material + $model->labour +  $model->other_expense / $model->total_unit_produced;
        });
    }
}
