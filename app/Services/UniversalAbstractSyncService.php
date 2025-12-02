<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class UniversalAbstractSyncService
{
    public function __construct(protected WbApiClient $client)
    {
    }

    public function sync(\DateTimeInterface $from, \DateTimeInterface $to): void
    {
        $page = 1;
        $limit = (int) config('services.wb.limit', 100);

        do {
            $response = $this->client->get($this->getApiEndpoint(), $this->buildParams($from, $to, $page, $limit));

            $data = $response['data'] ?? [];
            $meta = $response['meta'] ?? null;

            if (empty($data)) {
                Log::info("A gde infa ot {$this->getEntityName()} A?", ['page' => $page]);
                break;
            }

            DB::beginTransaction();
            try {
                foreach ($data as $item) {
                    $this->getModel()::updateOrCreate(
                        $this->getUniqueKeys($item),
                        $this->mapData($item)
                    );
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Nemagu sync {$this->getEntityName()} sdelat", [
                    'page' => $page,
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }

            if (!$meta) {
                break;
            }

            $currentPage = (int) ($meta['current_page'] ?? $page);
            $lastPage = (int) ($meta['last_page'] ?? $currentPage);

            $page++;
            $hasMore = $currentPage < $lastPage;

        } while ($hasMore);

        Log::info("{$this->getEntityName()} fuuuh ystal yzhe)");
    }

    protected function buildParams(\DateTimeInterface $from, \DateTimeInterface $to, int $page, int $limit): array
    {
        return [
            'dateFrom' => $from->format('Y-m-d'),
            'dateTo' => $to->format('Y-m-d'),
            'page' => $page,
            'limit' => $limit,
        ];
    }

    /**
     * Дай endpoint мне
     */
    abstract protected function getApiEndpoint(): string;

    /**
     * Модель какая?
     */
    abstract protected function getModel(): string;

    /**
     * А ключи ?
     */
    abstract protected function getUniqueKeys(array $item): array;

    /**
     * Маппинг иныфы короче
     */
    abstract protected function mapData(array $item): array;

    /**
     * Ты кто?
     */
    protected function getEntityName(): string
    {
        return class_basename($this->getModel());
    }
}