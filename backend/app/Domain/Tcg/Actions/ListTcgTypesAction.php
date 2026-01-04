<?php

namespace App\Domain\Tcg\Actions;

use App\Domain\Tcg\Models\TcgType;
use Illuminate\Support\Collection;

class ListTcgTypesAction
{
    public function execute(): Collection
    {
        return TcgType::orderBy('description')->get();
    }
}
