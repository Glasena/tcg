<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\Card;
use App\Http\Requests\ListCardRequest;

class ListCardAction
{
    public function execute(ListCardRequest $request)
    {
        return Card::query()
            ->when($request->tcg_type_id, function ($query, $value) {
                return $query->where('tcg_type_id', $value);
            })
            ->when($request->name, function ($query, $value) {
                return $query->where('name', 'like', "%{$value}%");
            })
            ->when($request->tcg_custom_id, function ($query, $value) {
                return $query->where('tcg_custom_id', 'like', "%{$value}%");
            })
            ->when($request->id, function ($query, $value) {
                return $query->where('id', $value);
            })
            ->paginate($request->per_page ?? 18);
        ;
    }
}