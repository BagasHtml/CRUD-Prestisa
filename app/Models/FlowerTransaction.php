<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowerTransaction extends Model
{
    protected $fillable = [
        'flower_id',
        'type',
        'quantity',
        'reference_number',
        'transaction_date',
        'source_destination',
        'notes',
        'handled_by'
    ];

    protected $casts = [
        'transaction_date' => 'date'
    ];

    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }

    public function scopeMasuk($query)
    {
        return $query->where('type', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('type', 'keluar');
    }
}