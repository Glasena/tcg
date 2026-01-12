<?php

namespace App\Domain\Tcg\DTOs;

use App\Http\Requests\UpdateCardRequest;
use Illuminate\Http\UploadedFile;

readonly class UpdateCardData
{
    public function __construct(
        public int $id,
        public ?int $tcg_type_id = null,
        public ?string $tcg_custom_id = null,
        public ?string $name = null,
        public ?UploadedFile $image = null,
    ) {
    }

    public static function fromRequest(UpdateCardRequest $request, int $id): self
    {
        return new self(
            id: $id,
            tcg_type_id: $request->tcg_type_id,
            tcg_custom_id: $request->tcg_custom_id,
            name: $request->name,
            image: $request->file('image'),
        );
    }
}