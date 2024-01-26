<?php

namespace App\Services\User\Action;

use App\Models\Company\UserCompany;
use App\Models\User\User;
use App\Services\User\Dto\CreateUserDto;
use Carbon\Carbon;

class CreateUserAction
{
    public function run(CreateUserDto $dto): void
    {
        $user = User::query()->create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => $dto->password,
                'status' => $dto->status,
        ]);

        $user->assignRole($dto->role);

        $owner = User::query()->find($dto->userId);

        UserCompany::query()->insert([
            'user_id' => $user->id,
            'company_id' => $owner->companies->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
