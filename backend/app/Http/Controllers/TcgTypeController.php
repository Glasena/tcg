<?php

namespace App\Http\Controllers;

use App\Http\Resources\TcgTypeResource;
use App\Models\TcgType;
use Illuminate\Http\Request;

class TcgTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //@todo rever isso pra separar as responsabilidades.
        return TcgTypeResource::collection(
            TcgType::orderBy('description')->get()
        );
    }

}
