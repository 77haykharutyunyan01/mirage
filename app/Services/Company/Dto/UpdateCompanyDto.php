<?php

namespace App\Services\Company\Dto;

use App\Http\Requests\Company\UpdateCompanyRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateCompanyDto extends DataTransferObject
{
    public string $id;
    public string $status;
    public string $userId;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(UpdateCompanyRequest $request): UpdateCompanyDto
    {
        return new self(
            id: $request->getId(),
            status: $request->getStatus(),
            userId: $request->getUserId()
        );
    }
}
