<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\CreateCardData;
use App\Domain\Tcg\Models\Card;

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
