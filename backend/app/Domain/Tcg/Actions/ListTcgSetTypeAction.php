<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\DTOs\ListTcgSetTypeData;
use App\Domain\Tcg\Models\TcgSetType;

class ListTcgSetTypeAction
{
    public function execute(ListTcgSetTypeData $data)
    {
        return TcgSetType::query()
            ->when($data->code, function ($query, $value) {
                return $query->where('code', $value);
            })
            ->when($data->name, function ($query, $value) {
                return $query->where('name', 'ilike', "%{$value}%");
            })
            ->when($data->tcg_type_id, function ($query, $value) {
                return $query->where('tcg_type_id', $value);
            })
            ->get();
    }
}