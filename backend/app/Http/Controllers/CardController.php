<?php

namespace App\Http\Controllers;

use App\Domain\Tcg\Actions\CreateCardAction;
use App\Domain\Tcg\Actions\DestroyCardAction;
use App\Domain\Tcg\Actions\ListCardAction;
use App\Domain\Tcg\Actions\ShowCardAction;
use App\Domain\Tcg\Actions\UpdateCardAction;
use App\Domain\Tcg\DTOs\CreateCardData;
use App\Domain\Tcg\DTOs\UpdateCardData;
use App\Domain\Tcg\Models\Card;
use App\Http\Requests\CreateCardRequest;
use App\Http\Requests\ListCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Resources\CardResource;

class CardController extends Controller
{

    // Quando eu passo uma classe, o Service Container a implementa automaticamente via DI.

    public function store(CreateCardRequest $request, CreateCardAction $action)
    {

        $cardData = CreateCardData::fromRequest($request);

        return new CardResource($action->execute($cardData));
    }

    public function index(ListCardRequest $request, ListCardAction $action)
    {
        return CardResource::collection($action->execute($request));
    }

    public function show(Card $card, ShowCardAction $action)
    {
        return new CardResource($action->execute($card));
    }

    public function update(UpdateCardRequest $request, Card $card, UpdateCardAction $action)
    {
        $data = UpdateCardData::fromRequest($request, $card->id);
        return new CardResource($action->execute($data));
    }

    public function destroy(Card $card, DestroyCardAction $action)
    {
        $action->execute($card);
        return response()->noContent();
    }

}