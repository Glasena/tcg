<?php

namespace App\Http\Controllers;

use App\Domain\Tcg\Actions\CreateCardAction;
use App\Domain\Tcg\Actions\ListCardAction;
use App\Http\Requests\CreateCardRequest;
use App\Http\Requests\ListCardRequest;
use App\Http\Resources\CardResource;

class CardController extends Controller
{

    // Quando eu passo uma classe, o Service Container a implementa automaticamente via DI.

    public function store(CreateCardRequest $request, CreateCardAction $action)
    {

        $card = $action->execute(
            $request
        );

        return new CardResource($card);
    }

    public function show(ListCardRequest $request, ListCardAction $action)
    {
        $cards = $action->execute(
            $request
        );

        return new CardResource($cards);
    }

}