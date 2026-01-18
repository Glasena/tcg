<?php

namespace App\Domain\Cards\Actions;

use App\Domain\Cards\Models\Card;
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
                return $query->where('name', 'ilike', "%{$value}%");
            })
            ->when($request->tcg_custom_id, function ($query, $value) {
                return $query->where('tcg_custom_id', 'ilike', "%{$value}%");
            })
            ->when($request->id, function ($query, $value) {
                return $query->where('id', $value);
            })
            ->when($request->tcg_set_type_id, function ($query, $value) {
                return $query->whereHas('tcgSetTypes', function ($q) use ($value) {
                    $q->where('tcg_set_types.id', $value);
                });
            })
            ->when($request->code, function ($query, $value) {
                return $query->whereHas('cardTcgSetTypes', function ($q) use ($value) {
                    $q->where('code', 'like', "%{$value}%");
                });
            })
            ->paginate($request->per_page ?? 18);
        ;
    }
}