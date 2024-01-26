<?php

namespace App\Services\User\Dto;

use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Traits\Helper\Uuid;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateUserDto extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public ?string $status;
    public string $userId;

    public static function fromRequest(CreateUserRequest $request): CreateUserDto
    {
        return new self(
            name: $request->getName(),
            email: $request->getEmail(),
            password: $request->getPassword(),
            role: $request->getRole(),
            status: $request->getUserStatus(),
            userId: $request->getUserId(),
        );
    }
}
