<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Cards\Models\Card;

class DestroyCardAction
{
    public function execute(Card $card)
    {
        return $card->delete();
    }
}
