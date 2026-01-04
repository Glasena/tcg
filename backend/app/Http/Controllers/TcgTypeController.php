<?php

namespace App\Http\Controllers;

use App\Domain\Tcg\Actions\ListTcgTypesAction;
use App\Http\Resources\TcgTypeResource;

class TcgTypeController extends Controller
{
    public function index(ListTcgTypesAction $action)
    {
        return TcgTypeResource::collection(
            $action->execute()
        );
    }
}
