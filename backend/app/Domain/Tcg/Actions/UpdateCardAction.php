<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\UpdateCardData;
use App\Domain\Tcg\Models\Card;
use Storage;

class UpdateCardAction
{
    public function execute(UpdateCardData $data): Card
    {
        $card = Card::findOrFail($data->id);

        $attributes = array_filter([
            'tcg_type_id' => $data->tcg_type_id,
            'tcg_custom_id' => $data->tcg_custom_id,
            'name' => $data->name,
        ], fn($value) => $value !== null);

        if ($data->image) {

            if ($card->img_url) {
                Storage::disk('public')->delete($card->img_url);
            }

            $attributes['img_url'] = $data->image->store('cards', 'public');
        }

        $card->update($attributes);

        return $card->fresh();
    }
}
