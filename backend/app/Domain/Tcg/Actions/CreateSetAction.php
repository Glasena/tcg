<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\CreateTcgSetTypeData;
use App\Domain\Tcg\Models\TcgSetType;

class CreateSetAction
{
    public function execute(CreateTcgSetTypeData $data): TcgSetType
    {
        return TcgSetType::create(
            [
                'name' => $data->name,
                'tcg_type_id' => $data->tcg_type_id,
                'img_url' => $data->image,
                'num_of_cards' => $data->num_of_cards,
                'date' => $data->date,
                'code' => $data->code
            ]
        );
    }
}
