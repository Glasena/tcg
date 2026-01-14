<?php

namespace App\Jobs;

use App\Domain\Tcg\Actions\CreateOrUpdateCardAction;
use App\Domain\Tcg\Actions\DownloadCardImageAction;
use App\Domain\Tcg\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportSingleCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $cardData)
    {
    }

    public function handle(CreateOrUpdateCardAction $createOrUpdateCardAction, DownloadCardImageAction $downloadCardImageAction): void
    {
        try {
            $imagePath = null;

            if (isset($this->cardData['card_images'][0]['image_url'])) {
                $imagePath = $downloadCardImageAction->execute(
                    $this->cardData['card_images'][0]['image_url']
                );
            }

            $createOrUpdateCardAction->execute(
                new \App\Domain\Tcg\DTOs\CreateCardData(
                    tcg_custom_id: $this->cardData['id'],
                    name: $this->cardData['name'],
                    tcg_type_id: Card::TYPE_YUGIOH,
                    image: $imagePath,
                )
            );

        } catch (\Exception $e) {
            \Log::error('Import failed', [
                'card' => $this->cardData['name'] ?? 'Unknown',
                'error' => $e->getMessage(),
            ]);
        }
    }
}