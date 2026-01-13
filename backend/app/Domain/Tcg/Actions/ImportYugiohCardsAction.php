<?php

namespace App\Domain\Tcg\Actions;

use App\Jobs\ImportSingleCardJob;
use Illuminate\Support\Facades\Http;

class ImportYugiohCardsAction
{
    public function execute(callable $onProgress): int
    {
        $offset = 0;
        $perPage = 100;
        $totalImported = 0;

        do {
            $onProgress("🔄 Buscando cards (offset: $offset)...");

            $response = Http::timeout(30)->get('https://db.ygoprodeck.com/api/v7/cardinfo.php', [
                'num' => $perPage,
                'offset' => $offset,
            ]);

            if ($response->failed()) {
                $onProgress("❌ Falha na API (status: {$response->status()})");
                break;
            }

            $data = $response->json();
            $cards = $data['data'] ?? [];
            $meta = $data['meta'] ?? null;

            $onProgress("✅ Recebidos " . count($cards) . " cards");

            foreach ($cards as $cardData) {
                ImportSingleCardJob::dispatch($cardData);
                $totalImported++;
            }

            $offset += $perPage;

            if (!$meta || $meta['pages_remaining'] == 0) {
                break;
            }

        } while (true);

        return $totalImported;
    }
}