<?php

namespace App\Domain\Cards\Actions;

use App\Jobs\ImportSingleSetJob;
use Illuminate\Support\Facades\Http;

class ImportYugiohCardSetsAction
{
    public function execute(callable $onProgress): int
    {
        $offset = 0;
        $perPage = 100;
        $totalImported = 0;

        $onProgress("🔄 Getting Sets (offset: $offset)...");

        $response = Http::timeout(100)->get('https://db.ygoprodeck.com/api/v7/cardsets.php');

        if ($response->failed()) {
            $onProgress("❌ API Error (status: {$response->status()})");

        }

        $sets = $response->json() ?? [];

        $onProgress("✅ Received " . count($sets) . " sets");

        foreach ($sets as $setData) {
            ImportSingleSetJob::dispatch($setData);
            $totalImported++;
        }

        return $totalImported;
    }
}