<?php

namespace App\Http\Requests\Company;

use App\Models\User\User;
use App\Traits\Auth\AuthIdTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    use AuthIdTrait;

    const ID = 'id';
    const STATUS = 'status';

//    public function authorize(): bool
//    {
//        return $this->user()->can('authorizeRoot', User::class);
//    }

    public function rules(): array
    {
        return [
            self::ID => [
                'required',
                'string',
            ],

            self::STATUS => [
                'required',
                'string',
            ],
        ];
    }

    public function getId(): string
    {
        return $this->get(self::ID);
    }

    public function getStatus(): string
    {
        return $this->get(self::STATUS);
    }
}
