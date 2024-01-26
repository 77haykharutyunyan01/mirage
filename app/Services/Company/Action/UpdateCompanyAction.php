<?php

namespace App\Services\Company\Action;

use App\Models\Company\Company;
use App\Services\Company\Dto\UpdateCompanyDto;

class UpdateCompanyAction
{
    public function run(UpdateCompanyDto $dto): void
    {
        Company::query()->where('id', $dto->id)->update(['status' => $dto->status]);
    }
}
