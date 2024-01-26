<?php

namespace App\Services\Auth\Login\Dto;

use App\Http\Requests\Auth\LoginRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LoginUserDto extends DataTransferObject
{
    public string $email;
    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(LoginRequest $request): LoginUserDto
    {
        return new self(
            email: $request->getEmail(),
            password: $request->getPassword()
        );
    }
}
