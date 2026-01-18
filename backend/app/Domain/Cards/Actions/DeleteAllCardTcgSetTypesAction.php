<?php

namespace App\Domain\Cards\Actions;

use App\Domain\Cards\Models\CardTcgSetType;

class DeleteAllCardTcgSetTypesAction
{
    public function execute(): int
    {
        return CardTcgSetType::query()->delete();
    }
}