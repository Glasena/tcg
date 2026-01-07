<?php

namespace App\Domain\Tcg\Data;

use App\Http\Requests\CreateCardRequest;

readonly class CardData
{
    public function __construct(
        public int $tcg_type_id,
        public string $tcg_custom_id,
        public string $name,
    ) {
    }

    public static function fromRequest(CreateCardRequest $request): self
    {
        return new self(
            tcg_type_id: $request->tcg_type_id,
            tcg_custom_id: $request->tcg_custom_id,
            name: $request->name,
        );
    }
}