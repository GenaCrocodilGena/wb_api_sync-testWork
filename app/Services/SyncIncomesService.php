<?php

namespace App\Services;

use App\Models\Income;

class SyncIncomesService extends UniversalAbstractSyncService
{
    protected function getApiEndpoint(): string
    {
        return '/api/incomes';
    }

    protected function getModel(): string
    {
        return Income::class;
    }

    protected function getUniqueKeys(array $item): array
    {
        return [
            'income_id' => $item['income_id'] ?? null,
            'nm_id' => $item['nm_id'] ?? null,
        ];
    }

    protected function mapData(array $item): array
    {
        return [
            'number' => $item['number'] ?? null,
            'date' => $item['date'] ?? null,
            'last_change_date' => $item['last_change_date'] ?? null,
            'supplier_article' => $item['supplier_article'] ?? null,
            'tech_size' => $item['tech_size'] ?? null,
            'barcode' => $item['barcode'] ?? null,
            'quantity' => $item['quantity'] ?? 0,
            'total_price' => $item['total_price'] ?? 0,
            'date_close' => $item['date_close'] ?? null,
            'warehouse_name' => $item['warehouse_name'] ?? null,
            'payload' => $item,
        ];
    }
}