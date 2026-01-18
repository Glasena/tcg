<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Cards\Models\Card;

class ShowCardAction
{
    public function execute(Card $card): Card
    {
        return $card;
    }
}