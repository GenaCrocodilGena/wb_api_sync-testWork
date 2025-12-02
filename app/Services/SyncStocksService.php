<?php

namespace App\Services;

use App\Models\Stock;

class SyncStocksService extends UniversalAbstractSyncService
{
    protected function getApiEndpoint(): string
    {
        return '/api/stocks';
    }

    protected function getModel(): string
    {
        return Stock::class;
    }

    protected function getUniqueKeys(array $item): array
    {
        return [
            'barcode' => $item['barcode'] ?? null,
            'nm_id' => $item['nm_id'] ?? null,
            'warehouse_name' => $item['warehouse_name'] ?? null,
        ];
    }

    protected function mapData(array $item): array
    {
        return [
            'date' => $item['date'] ?? null,
            'last_change_date' => $item['last_change_date'] ?? null,
            'supplier_article' => $item['supplier_article'] ?? null,
            'tech_size' => $item['tech_size'] ?? null,
            'quantity' => $item['quantity'] ?? 0,
            'is_supply' => $item['is_supply'] ?? false,
            'is_realization' => $item['is_realization'] ?? false,
            'quantity_full' => $item['quantity_full'] ?? 0,
            'in_way_to_client' => $item['in_way_to_client'] ?? null,
            'in_way_from_client' => $item['in_way_from_client'] ?? null,
            'subject' => $item['subject'] ?? null,
            'category' => $item['category'] ?? null,
            'brand' => $item['brand'] ?? null,
            'sc_code' => $item['sc_code'] ?? null,
            'price' => $item['price'] ?? null,
            'discount' => $item['discount'] ?? null,
            'payload' => $item,
        ];
    }
    /**
     * Так как выгрузка только за текущий день поэтому надо переопределить параметры для сервиса склада 
     */
    protected function buildParams(\DateTimeInterface $from, \DateTimeInterface $to, int $page, int $limit): array
    {
        $date = $to < now() ? now() : $to;
        $dateStr = $date->format('Y-m-d');
        
        return [
            'dateFrom' => $dateStr,
            'dateTo' => $dateStr,
            'page' => $page,
            'limit' => $limit,
        ];
    }
}