<?php

namespace App\Services\Company\Action;

use App\Models\Company\Company;
use App\Models\User\User;
use App\Services\Company\Dto\CreateCompanyDto;
use App\Services\User\Dto\CreateUserDto;

class CreateCompanyAction
{
    public function run(CreateUserDto $userDto, CreateCompanyDto $companyDto): void
    {
        $user = User::query()->create([
                'name' => $userDto->name,
                'email' => $userDto->email,
                'password' => $userDto->password,
                'status' => $companyDto->status,
        ]);

        $user->assignRole($userDto->role);

        $company = Company::query()->create([
                'name' => $companyDto->name,
                'owner_id' => $user->id,
                'status' => $companyDto->status ?? 'active',
        ]);

        $company->users()->sync([$user->id]);
    }
}
