<?php

namespace App\Http\Controllers;

use App\Domain\Tcg\Actions\CreateTcgSetTypeAction;
use App\Domain\Tcg\Actions\ListTcgSetTypeAction;
use App\Domain\Tcg\DTOs\ListTcgSetTypeData;
use App\Domain\Tcg\DTOs\CreateTcgSetTypeData;
use App\Http\Requests\CreateTcgSetTypeRequest;
use App\Http\Requests\ListSetRequest;
use App\Http\Resources\TcgSetTypeResource;

class TcgSetTypeController extends Controller
{

    // Quando eu passo uma classe, o Service Container a implementa automaticamente via DI.

    public function store(CreateTcgSetTypeRequest $request, CreateTcgSetTypeAction $action)
    {
        $tcgSetTypeData = CreateTcgSetTypeData::fromRequest($request);

        return new TcgSetTypeResource($action->execute($tcgSetTypeData));
    }

    public function index(ListSetRequest $request, ListTcgSetTypeAction $action)
    {
        $data = ListTcgSetTypeData::from($request->validated());

        return TcgSetTypeResource::collection($action->execute($data));
    }
    /*
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
    }*/

}