<?php

namespace App\Services\User\Action;

use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class GetUsersAction
{

    public function run(string $userId): Collection
    {
        $user = User::query()->find($userId);

        $company = Company::query()
            ->where('owner_id', $user->companies->first()->owner_id)
            ->with('users')
            ->first();

        if (is_null($company)) {
            throw new NotFoundResourceException();
        }

        return $company->users;
    }
}
