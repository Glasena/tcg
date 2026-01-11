<?php

namespace App\Domain\Auth\Actions;

use App\Domain\Auth\DTOs\LoginData;
use App\Domain\User\Models\User;
use Illuminate\Validation\ValidationException;
use Hash;

class LoginUserAction
{
    public function execute(LoginData $data): User
    {
        $user = User::where('email', $data->email)->first();

        if (!$user || !Hash::check($data->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        return $user;
    }
}