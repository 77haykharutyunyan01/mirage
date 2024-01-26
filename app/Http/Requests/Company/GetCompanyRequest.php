<?php

namespace App\Http\Requests\Company;

use App\Models\User\User;
use App\Traits\Auth\AuthIdTrait;
use Illuminate\Foundation\Http\FormRequest;

class GetCompanyRequest extends FormRequest
{
    use AuthIdTrait;

    public const STATUS = 'status';

//    public function authorize(): bool
//    {
//        return $this->user()->can('authorizeRoot', User::class);
//    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getStatus()
    {
        return $this->query(self::STATUS);
    }
}
