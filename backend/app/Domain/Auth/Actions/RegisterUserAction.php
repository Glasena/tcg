<?php

namespace App\Domain\Auth\Actions;

use App\Domain\Auth\DTOs\RegisterData;
use App\Domain\User\Models\User;
use Hash;

class RegisterUserAction
{
    public function execute(RegisterData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'is_admin' => false,
        ]);
    }
}