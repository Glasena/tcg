<?php

namespace App\Http\Controllers;

use App\Domain\Auth\Actions\LoginUserAction;
use App\Domain\Auth\Actions\RegisterUserAction;
use App\Domain\Auth\DTOs\LoginData;
use App\Domain\Auth\DTOs\RegisterData;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function register(
        RegisterRequest $request,
        RegisterUserAction $action
    ) {
        $data = RegisterData::fromRequest($request);
        $user = $action->execute($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(
        LoginRequest $request,
        LoginUserAction $action
    ) {
        $data = LoginData::fromRequest($request);
        $user = $action->execute($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sucessful logout',
        ]);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}