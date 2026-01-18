<?php

namespace App\Jobs;

use App\Domain\Cards\Actions\CreateOrUpdateCardAction;
use App\Domain\Cards\Actions\CreateOrUpdateCardTcgSetTypeAction;
use App\Domain\Cards\DTOs\CreateCardData;
use App\Domain\Support\Actions\DownloadImageAction;
use App\Domain\Tcg\Actions\ListTcgSetTypeAction;
use App\Domain\Cards\DTOs\CreateCardTcgSetTypeData;
use App\Domain\Cards\Models\Card;
use App\Domain\Tcg\DTOs\ListTcgSetTypeData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSingleCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $cardData)
    {
    }

    public function handle(
        CreateOrUpdateCardAction $createOrUpdateCardAction,
        DownloadImageAction $downloadImageAction,
        ListTcgSetTypeAction $listTcgSetTypeAction,
        CreateOrUpdateCardTcgSetTypeAction $createOrUpdateCardTcgSetTypeAction,
    ): void {
        try {
            $imagePath = null;

            if (isset($this->cardData['card_images'][0]['image_url'])) {
                $imagePath = $downloadImageAction->execute(
                    $this->cardData['card_images'][0]['image_url'],
                    'cards'
                );
            }

            $card = $createOrUpdateCardAction->execute(
                new CreateCardData(
                    tcg_custom_id: $this->cardData['id'],
                    name: $this->cardData['name'],
                    tcg_type_id: Card::TYPE_YUGIOH,
                    image: $imagePath,
                )
            );

            $cardSets = !empty($this->cardData['card_sets']) ? $this->cardData['card_sets'] : [];

            foreach ($cardSets as $set) {

                $setCode = explode('-', $set['set_code'])[0];

                $tcgSetType = $listTcgSetTypeAction->execute(
                    new ListTcgSetTypeData(
                        code: $setCode,
                        name: $set['set_name'],
                        tcg_type_id: Card::TYPE_YUGIOH
                    )
                )->first();

                if (empty($tcgSetType)) {
                    continue;
                }

                $createOrUpdateCardTcgSetTypeAction->execute(
                    new CreateCardTcgSetTypeData(
                        tcgSetTypeId: $tcgSetType->id,
                        cardId: $card->id,
                        code: $set['set_code'],
                        rarityCode: $set['set_rarity_code'],
                        image: null
                    )
                );

            }

        } catch (\Exception $e) {
            \Log::error('Import failed', [
                'card' => $this->cardData['name'] ?? 'Unknown',
                'error' => $e->getMessage(),
            ]);
        }
    }
}