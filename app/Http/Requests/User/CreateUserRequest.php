<?php

namespace App\Http\Requests\User;

use App\Traits\Auth\AuthIdTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    use AuthIdTrait;

    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const ROLE = 'role';
    public const USER_STATUS = 'user_status';

    public function rules(): array
    {
        return [
            self::NAME => [
                'required',
                'string',
            ],
            self::EMAIL => [
                'required',
                'string',
            ],
            self::PASSWORD => [
                'required',
                'string',
            ],
            self::ROLE => [
                'required',
                'string',
            ],
            self::USER_STATUS => [
                'required',
                'string',
            ],
        ];
    }

    public function getName(): string
    {
        return $this->get(self::NAME);
    }

    public function getEmail(): string
    {
        return $this->get(self::EMAIL);
    }

    public function getPassword(): string
    {
        return $this->get(self::PASSWORD);
    }

    public function getRole(): string
    {
        return $this->get(self::ROLE);
    }

    public function getUserStatus(): ?string
    {
        return $this->get(self::USER_STATUS);
    }
}
