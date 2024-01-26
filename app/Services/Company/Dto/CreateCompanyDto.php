<?php

namespace App\Services\Company\Dto;

use App\Http\Requests\Company\CreateCompanyRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateCompanyDto extends DataTransferObject
{
    public string $name;
    public string $status;
    public ?string $ownerId;

    public static function fromRequest(CreateCompanyRequest $request): CreateCompanyDto
    {
        return new self(
            name: $request->getCompanyName(),
            status: $request->getCompanyStatus()
        );
    }
}
