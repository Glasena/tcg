<?php

namespace App\Domain\Tcg\DTOs;

class ListTcgSetTypeData
{
    public function __construct(
        public ?string $code = null,
        public ?string $name = null,
        public ?int $tcg_type_id = null,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            code: $data['code'] ?? null,
            name: $data['name'] ?? null,
            tcg_type_id: $data['tcg_type_id'] ?? null,
        );
    }
}