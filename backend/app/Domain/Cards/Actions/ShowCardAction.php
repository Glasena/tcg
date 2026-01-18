<?php

namespace App\Domain\Cards\Actions;

use App\Domain\Cards\Models\Card;

class ShowCardAction
{
    public function execute(Card $card): Card
    {
        return $card;
    }
}