<?php

namespace App\Jobs\Comment\UseCases;

use App\Models\FbAccount;

class GenerateDataForGetPostIdUseCase
{
    public function run(FbAccount $fbAccount): array
    {
        $headers = [
            'Authority' => 'www.facebook.com',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Cookie' => $fbAccount->cookie,
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => $fbAccount->user_agent,
        ];

        return [
            'headers' => $headers
        ];
    }
}
