<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\TcgSetType;

class ListTcgSetTypeAction
{
    public function execute($code, $name, $tcgTypeId)
    {
        return TcgSetType::where(function ($query) use ($code, $name) {
            $query->where('code', $code)
                ->orWhere('name', $name);
        })->where('tcg_type_id', $tcgTypeId)->get();
    }
}