<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\Card;

class ShowCardAction
{
    public function execute(Card $card): Card
    {
        return $card;
    }
}