<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Services\Company\Action\CreateCompanyAction;
use App\Services\Company\Dto\CreateCompanyDto;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CreateCompanyController extends Controller
{
    public function __invoke(
        CreateCompanyRequest $request,
        CreateCompanyAction $createCompany
    ): RedirectResponse {
        $userDto = CreateUserDto::fromRequest($request);
        $companyDto = CreateCompanyDto::fromRequest($request);

        $createCompany->run($userDto, $companyDto);

        return redirect('admin/companies');
    }
}
