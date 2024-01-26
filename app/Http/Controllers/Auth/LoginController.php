<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\Login\Dto\LoginUserDto;
use App\Services\Auth\Login\Action\LoginAction;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(
        LoginRequest $request,
        LoginAction $loginAction
    ) {
        $dto = LoginUserDto::fromRequest($request);

        $result = $loginAction->run($dto);

        if ($result) {
            if($request->user()?->roles->first()->name === 'root') {
                return redirect('/admin/companies');
            }

            return redirect('admin/user');
        }

        return redirect()->back();
    }
}
