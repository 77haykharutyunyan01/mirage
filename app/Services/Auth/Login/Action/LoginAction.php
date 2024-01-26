<?php

namespace App\Services\Auth\Login\Action;

use App\Services\Auth\Login\Dto\LoginUserDto;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function run(LoginUserDto $dto): bool
    {
        if (Auth::attempt(['email' => $dto->email, 'password' => $dto->password])) {
            return true;
        }

        return false;
    }
}
