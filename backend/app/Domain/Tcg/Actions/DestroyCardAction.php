<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\Card;

class DestroyCardAction
{
    public function execute(Card $card)
    {
        return $card->delete();
    }
}
