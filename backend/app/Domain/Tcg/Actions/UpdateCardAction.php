<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\UpdateCardData;
use App\Domain\Tcg\Models\Card;

class UpdateCardAction
{
    public function execute(UpdateCardData $data): Card
    {
        $card = Card::findOrFail($data->id);

        $card->update(array_filter([
            'tcg_type_id' => $data->tcg_type_id,
            'tcg_custom_id' => $data->tcg_custom_id,
            'name' => $data->name,
        ]));

        return $card->fresh();
    }
}
