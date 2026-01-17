<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\CardTcgSetType;

class DeleteAllCardTcgSetTypesAction
{
    public function execute(): int
    {
        return CardTcgSetType::query()->delete();
    }
}