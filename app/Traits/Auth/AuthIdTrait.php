<?php

namespace App\Traits\Auth;

use Illuminate\Support\Facades\Auth;

trait AuthIdTrait
{
    public function getUserId(): string
    {
        return Auth::user()?->getAuthIdentifier() ?? 1;
    }
}
