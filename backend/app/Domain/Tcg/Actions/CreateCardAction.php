<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\Card;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateCardAction
{
    public function execute(
        int $tcgTypeId,
        string $tcgCustomId,
        string $name
    ): Card {
        return DB::transaction(function () use ($tcgTypeId, $tcgCustomId, $name) {

            $exists = Card::where('tcg_custom_id', $tcgCustomId)
                ->where('tcg_type_id', $tcgTypeId)
                ->exists();

            if ($exists) {
                throw new RuntimeException('Card already exists.');
            }

            return Card::create([
                'name' => $name,
                'tcg_custom_id' => $tcgCustomId,
                'tcg_type_id' => $tcgTypeId,
            ]);
        });
    }
}
