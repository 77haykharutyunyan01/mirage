<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Services\Company\Action\UpdateCompanyAction;
use App\Services\Company\Dto\UpdateCompanyDto;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateCompanyController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function __invoke(
        UpdateCompanyRequest $request,
        UpdateCompanyAction $updateCompanyAction
    ): JsonResponse {
        $dto = UpdateCompanyDto::fromRequest($request);

        $updateCompanyAction->run($dto);

        return $this->response();
    }
}
