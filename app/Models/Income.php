<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'income_id',
        'number',
        'date',
        'last_change_date',
        'supplier_article',
        'tech_size',
        'barcode',
        'quantity',
        'total_price',
        'date_close',
        'warehouse_name',
        'nm_id',
        'payload',
    ];

    protected $casts = [
        'income_id'             => 'integer',

        'date'                  => 'date',
        'last_change_date'      => 'date',
        'date_close'            => 'date',

        'barcode'               => 'integer',
        'nm_id'                 => 'integer',
        'quantity'              => 'integer',

        'total_price'           => 'decimal:2',

        'payload'          => 'array',
    ];
}
