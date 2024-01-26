<?php

namespace App\Services\Fb;

use App\Models\FbAccount;

class FbApiFactory
{
    public function run(FbAccount $account): FbApi
    {
        return new FbApi($account);
    }
}
