<?php

namespace App\Domain\Cards\Actions;

use App\Domain\Cards\DTOs\CreateCardData;
use App\Domain\Cards\Models\Card;

class CreateOrUpdateCardAction
{
    public function execute(CreateCardData $data): Card
    {
        return Card::updateOrCreate(
            ['tcg_custom_id' => $data->tcg_custom_id],
            [
                'name' => $data->name,
                'tcg_type_id' => $data->tcg_type_id,
                'img_url' => $data->image,
            ]
        );
    }
}
