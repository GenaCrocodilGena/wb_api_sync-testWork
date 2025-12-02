<?php

namespace App\Services;

use App\Models\Sale;

class SyncSalesService extends UniversalAbstractSyncService
{
    protected function getApiEndpoint(): string
    {
        return '/api/sales';
    }

    protected function getModel(): string
    {
        return Sale::class;
    }

    protected function getUniqueKeys(array $item): array
    {
        return [
            'sale_id' => $item['sale_id'] ?? null,
        ];
    }

    protected function mapData(array $item): array
    {
        return [
            'g_number' => $item['g_number'] ?? null,
            'date' => $item['date'] ?? null,
            'last_change_date' => $item['last_change_date'] ?? null,
            'supplier_article' => $item['supplier_article'] ?? null,
            'tech_size' => $item['tech_size'] ?? null,
            'barcode' => $item['barcode'] ?? null,
            'total_price' => $item['total_price'] ?? null,
            'discount_percent' => $item['discount_percent'] ?? null,
            'is_supply' => $item['is_supply'] ?? false,
            'is_realization' => $item['is_realization'] ?? false,
            'promo_code_discount' => $item['promo_code_discount'] ?? null,
            'warehouse_name' => $item['warehouse_name'] ?? null,
            'country_name' => $item['country_name'] ?? null,
            'oblast_okrug_name' => $item['oblast_okrug_name'] ?? null,
            'region_name' => $item['region_name'] ?? null,
            'income_id' => $item['income_id'] ?? null,
            'odid' => $item['odid'] ?? null,
            'nm_id' => $item['nm_id'] ?? null,
            'spp' => $item['spp'] ?? null,
            'subject' => $item['subject'] ?? null,
            'category' => $item['category'] ?? null,
            'brand' => $item['brand'] ?? null,
            'for_pay' => $item['for_pay'] ?? null,
            'finished_price' => $item['finished_price'] ?? null,
            'price_with_disc' => $item['price_with_disc'] ?? null,
            'is_storno' => $item['is_storno'] ?? null,
            'payload' => $item,
        ];
    }
}