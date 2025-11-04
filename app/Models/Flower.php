<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'stock',
        'price',
        'supplier',
        'description',
        'image'
    ];

    public function transactions()
    {
        return $this->hasMany(FlowerTransaction::class);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock', '<', 10);
    }
}