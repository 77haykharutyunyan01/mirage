<?php

namespace App\Services\Company\Action;

use App\Models\Company\Company;
use App\Services\Company\Dto\GetCompanyDto;
use Illuminate\Database\Eloquent\Collection;

class GetCompanyAction
{
    public function run(GetCompanyDto $dto): Collection
    {
        $query = Company::query();

        if (!is_null($dto->status)) {
            $query->where('status', $dto->status);
        }

        return $query->with('owner')->get();
    }
}
