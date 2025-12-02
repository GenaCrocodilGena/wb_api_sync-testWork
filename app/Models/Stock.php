<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'date',
        'last_change_date',
        'supplier_article',
        'tech_size',
        'barcode',
        'quantity',
        'is_supply',
        'is_realization',
        'quantity_full',
        'warehouse_name',
        'in_way_to_client',
        'in_way_from_client',
        'nm_id',
        'subject',
        'category',
        'brand',
        'sc_code',
        'price',
        'discount',
        'payload',
    ];

    protected $casts = [
        'date' => 'date',
        'last_change_date' => 'date',
        'barcode' => 'integer',
        'nm_id' => 'integer',
        'quantity' => 'integer',
        'quantity_full' => 'integer',
        'in_way_to_client' => 'integer',
        'in_way_from_client' => 'integer',
        'sc_code' => 'integer',
        'price' => 'decimal:2',
        'discount' => 'integer',
        'is_supply' => 'boolean',
        'is_realization' => 'boolean',
        'payload' => 'array',
    ];
}