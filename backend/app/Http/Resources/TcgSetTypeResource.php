<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TcgSetTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'tcg_type_id' => $this->tcg_type_id
        ];
    }
}
