<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Data\CardData;
use App\Domain\Tcg\Models\Card;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateCardAction
{
    public function execute(CardData $data): Card
    {
        return DB::transaction(function () use ($data) {

            $exists = Card::where('tcg_custom_id', $data->tcg_custom_id)
                ->where('tcg_type_id', $data->tcg_type_id)
                ->exists();

            if ($exists) {
                throw new RuntimeException('Card already exists.');
            }

            return Card::create([
                'name' => $data->name,
                'tcg_custom_id' => $data->tcg_custom_id,
                'tcg_type_id' => $data->tcg_type_id,
            ]);
        });
    }
}
