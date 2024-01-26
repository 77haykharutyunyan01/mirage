<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\User\User;

class CreateCompanyRequest extends CreateUserRequest
{
    public const COMPANY_NAME = 'company_name';
    public const COMPANY_STATUS = 'company_status';

//    public function authorize(): bool
//    {
//        return $this->user()->can('authorizeRoot', User::class);
//    }

    public function rules(): array
    {
        return [
            self::COMPANY_NAME => [
                'required',
                'string',
            ],
            self::COMPANY_STATUS => [
                'required',
                'string',
            ],
        ];
    }

    public function getCompanyName(): string
    {
        return $this->get(self::COMPANY_NAME);
    }

    public function getCompanyStatus(): string
    {
        return $this->get(self::COMPANY_STATUS);
    }
}
