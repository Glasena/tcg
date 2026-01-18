<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'tcg_type_id' => $this->tcg_type_id,
            'tcg_custom_id' => $this->tcg_custom_id,
            'image_url' => $this->img_url
                ? Storage::url($this->img_url)
                : null,
            'card_sets' => CardTcgSetTypeResource::collection($this->whenLoaded('cardSets')),
        ];
    }
}
