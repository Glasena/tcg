<?php

namespace App\Domain\Tcg\DTOs;

use App\Http\Requests\CreateTcgSetTypeRequest;

readonly class CreateTcgSetTypeData
{
    public function __construct(
        public int $tcg_type_id,
        public string $name,
        public string $code,
    ) {
    }

    public static function fromRequest(CreateTcgSetTypeRequest $request): self
    {
        return new self(
            tcg_type_id: $request->tcg_type_id,
            name: $request->name,
            code: $request->code
        );
    }
}