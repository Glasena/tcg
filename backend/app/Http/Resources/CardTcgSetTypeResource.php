<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardTcgSetTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'set_name' => $this->tcgSetType->name ?? 'Unknown Set',
            'code' => $this->code,
            'rarity_code' => $this->rarity_code,
        ];
    }
}