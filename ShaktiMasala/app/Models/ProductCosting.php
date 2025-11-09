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
        parent::boot();
        static::creating(function ($model) {
            $total_cosnt = $model->raw_material + $model->labour +  $model->other_expense;
            $model->price_per_unit = $total_cosnt / $model->total_unit_produced;
        });
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
