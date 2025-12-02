<?php

namespace App\Services;

use App\Models\Order;

class SyncOrdersService extends UniversalAbstractSyncService
{
    protected function getApiEndpoint(): string
    {
        return '/api/orders';
    }

    protected function getModel(): string
    {
        return Order::class;
    }

    protected function getUniqueKeys(array $item): array
    {
        return [
            'g_number' => $item['g_number'] ?? null,
            'nm_id' => $item['nm_id'] ?? null,
            'barcode' => $item['barcode'] ?? null,
        ];
    }

    protected function mapData(array $item): array
    {
        return [
            'date' => $item['date'] ?? null,
            'last_change_date' => $item['last_change_date'] ?? null,
            'supplier_article' => $item['supplier_article'] ?? null,
            'tech_size' => $item['tech_size'] ?? null,
            'total_price' => $item['total_price'] ?? null,
            'discount_percent' => $item['discount_percent'] ?? null,
            'warehouse_name' => $item['warehouse_name'] ?? null,
            'oblast' => $item['oblast'] ?? null,
            'income_id' => $item['income_id'] ?? null,
            'odid' => $item['odid'] ?? null,
            'subject' => $item['subject'] ?? null,
            'category' => $item['category'] ?? null,
            'brand' => $item['brand'] ?? null,
            'is_cancel' => $item['is_cancel'] ?? false,
            'cancel_dt' => $item['cancel_dt'] ?? null,
            'payload' => $item,
        ];
    }
}