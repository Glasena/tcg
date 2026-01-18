<?php

namespace App\Domain\Cards\Actions;

use App\Domain\Cards\Models\Card;

class DestroyCardAction
{
    public function execute(Card $card)
    {
        return $card->delete();
    }
}
