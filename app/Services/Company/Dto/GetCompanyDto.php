<?php

namespace App\Services\Company\Dto;

use App\Http\Requests\Company\GetCompanyRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetCompanyDto extends DataTransferObject
{
    public ?string $userId;
    public ?string $status;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(GetCompanyRequest $request): GetCompanyDto
    {
        return new self(
            status: $request->getStatus()
        );
    }
}
