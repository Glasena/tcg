<?php

namespace App\Http\Controllers;

use App\Domain\Tcg\Actions\CreateCardAction;
use App\Http\Requests\CreateCardRequest;
use App\Http\Resources\CardResource;

class CardController extends Controller
{
    public function store(CreateCardRequest $request, CreateCardAction $action)
    {

        $card = $action->execute(
            $request->tcg_type_id,
            $request->tcg_custom_id,
            $request->name
        );

        return new CardResource($card);
    }
}