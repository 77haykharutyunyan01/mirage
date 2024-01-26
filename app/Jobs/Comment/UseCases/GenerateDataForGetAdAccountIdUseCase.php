<?php

namespace App\Jobs\Comment\UseCases;

use App\Models\FbAccount;

class GenerateDataForGetAdAccountIdUseCase
{
    public function run(FbAccount $fbAccount): array
    {
        $url = 'https://adsmanager.facebook.com/adsmanager/manage/campaigns/';

        $headers = [
            'accept' => '*/*',
            'accept-language' => 'ru-RU,ru;q=0.9;en-US,en;q=0.8',
            'referer' => 'https://facebook.com/',
            'sec-ch-ua' => '"Google Chrome";v="95", "Chromium";v="95", ";Not A Brand";v="99"',
            'sec-ch-ua-mobile' => '?0',
            'sec-ch-ua-platform' => '"Windows"',
            'sec-fetch-dest' => 'empty',
            'sec-fetch-mode' => 'cors',
            'sec-fetch-site' => 'same-origin',
            'user-agent' => $fbAccount->user_agent,
            'viewport-width' => '1920',
            'cookie' => $fbAccount->cookie
        ];

        return [
            'url' => $url,
            'headers' => $headers
        ];
    }
}
