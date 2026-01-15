<?php

namespace App\Domain\Tcg\DTOs;

use App\Http\Requests\CreateCardRequest;
use Illuminate\Http\UploadedFile;

readonly class CreateCardData
{
    public function __construct(
        public int $tcg_type_id,
        public string $tcg_custom_id,
        public string $name,
        public string|UploadedFile|null $image = null,
    ) {
    }

    public static function fromRequest(CreateCardRequest $request): self
    {
        return new self(
            tcg_type_id: $request->tcg_type_id,
            tcg_custom_id: $request->tcg_custom_id,
            name: $request->name,
            image: $request->file('image'),
        );
    }
}