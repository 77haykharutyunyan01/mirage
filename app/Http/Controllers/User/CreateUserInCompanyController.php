<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Services\User\Action\CreateUserAction;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Http\RedirectResponse;

class CreateUserInCompanyController extends Controller
{
    public function __invoke(
        CreateUserRequest $request,
        CreateUserAction $createUserAction
    ): RedirectResponse {
        $dto = CreateUserDto::fromRequest($request);

        $createUserAction->run($dto);

        return redirect('/admin/user');
    }
}
