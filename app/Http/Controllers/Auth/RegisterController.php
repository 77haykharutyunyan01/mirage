<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Register\Action\RegisterAction;
use App\Services\Register\Dto\RegisterDto;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function __invoke(
        RegisterRequest $request,
        RegisterAction $registerAction
    ): JsonResponse {
        $dto = RegisterDto::fromRequest($request);

        $registerAction->run($dto);

        return $this->response(
            statusCode: Response::HTTP_CREATED
        );
    }
}
