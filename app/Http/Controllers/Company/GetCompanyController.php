<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\GetCompanyRequest;
use App\Services\Company\Action\GetCompanyAction;
use App\Services\Company\Dto\GetCompanyDto;
use Illuminate\View\View;

class GetCompanyController extends Controller
{
    public function __invoke(
        GetCompanyRequest $request,
        GetCompanyAction $companyAction
    ): View {
        $dto = GetCompanyDto::fromRequest($request);

        $companies = $companyAction->run($dto);

        return view('Company/CompanyList', ['companies' => $companies, 'owner' => $request->user()]);
    }
}
