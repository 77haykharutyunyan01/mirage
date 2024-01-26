<?php

namespace App\Http\Controllers\User;

use App\Services\User\Action\GetUsersAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GetUsersController extends Controller
{
    public function __invoke(
        Request $request,
        GetUsersAction $getUsersAction
    ): View {
        $companyUsers = $getUsersAction->run($request->user()->id);

        return view('User/CompanyUserList', ['users' => $companyUsers, 'owner' => $request->user()]);
    }
}
