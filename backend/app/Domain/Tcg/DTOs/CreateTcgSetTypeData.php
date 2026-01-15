<?php

namespace App\Domain\Tcg\DTOs;

use App\Http\Requests\CreateTcgSetTypeRequest;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

readonly class CreateTcgSetTypeData
{
    public function __construct(
        public int $tcg_type_id,
        public string $name,
        public string $code,
        public string|UploadedFile|null $image = null,
        public ?Carbon $date = null,
        public ?int $num_of_cards = null,

    ) {
    }

    public static function fromRequest(CreateTcgSetTypeRequest $request): self
    {
        return new self(
            tcg_type_id: $request->tcg_type_id,
            name: $request->name,
            code: $request->code,
            image: $request->image,
            date: $request->date,
            num_of_cards: $request->num_of_cards,
        );
    }
}