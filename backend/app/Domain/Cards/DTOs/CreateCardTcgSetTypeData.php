<?php

namespace App\Domain\Cards\DTOs;

use Illuminate\Http\UploadedFile;

readonly class CreateCardTcgSetTypeData
{
    public function __construct(
        public int $tcgSetTypeId,
        public int $cardId,
        public string $code,
        public string $rarityCode,
        public string|UploadedFile|null $image = null,
    ) {
    }
}