<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\Card;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateCardAction
{
    public function execute(
        $request
    ): Card {
        return DB::transaction(function () use ($request) {

            $exists = Card::where('tcg_custom_id', $request->tcg_custom_id)
                ->where('tcg_type_id', $request->tcg_type_id)
                ->exists();

            if ($exists) {
                throw new RuntimeException('Card already exists.');
            }

            return Card::create([
                'name' => $request->name,
                'tcg_custom_id' => $request->tcg_custom_id,
                'tcg_type_id' => $request->tcg_type_id,
            ]);
        });
    }
}
