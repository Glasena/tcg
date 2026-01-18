<?php

namespace App\Domain\Cards\Actions;

use App\Domain\Cards\DTOs\CreateCardData;
use App\Domain\Cards\Models\Card;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CreateCardAction
{
    public function execute(CreateCardData $data): Card
    {
        return DB::transaction(function () use ($data) {

            $exists = Card::where('tcg_custom_id', $data->tcg_custom_id)
                ->where('tcg_type_id', $data->tcg_type_id)
                ->exists();

            if ($exists) {
                throw new RuntimeException('Card already exists.');
            }

            $imagePath = null;
            if ($data->image) {
                $imagePath = $data->image->store('cards', 'public'); // ← storage/app/public/cards
            }

            return Card::create([
                'name' => $data->name,
                'tcg_custom_id' => $data->tcg_custom_id,
                'tcg_type_id' => $data->tcg_type_id,
                'img_url' => $imagePath,
            ]);
        });
    }
}
