<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\CreateCardTcgSetTypeData;
use App\Domain\Tcg\Models\CardTcgSetType;

class CreateOrUpdateCardTcgSetTypeAction
{
    public function execute(CreateCardTcgSetTypeData $data): CardTcgSetType
    {
        return CardTcgSetType::updateOrCreate(
            ['tcg_set_type_id' => $data->tcgSetTypeId, 'card_id' => $data->cardId],
            [
                'code' => $data->code,
                'img_url' => $data->image,
                'rarity_code' => $data->rarityCode,
            ]
        );
    }
}
