<?php

namespace App\Jobs\Comment\UseCases;

use App\Models\FbAccount;

class GenerateDataForCreateChildCommentUseCase
{
    public function run(FbAccount $fbAccount, string $parentId, string $taskValue): array
    {
        $url = 'https://graph.facebook.com/v18.0/' . $parentId . '/comments?access_token=' . $fbAccount->token;

        $message = explode(',', $taskValue)[0];
        $image = explode(',', $taskValue)[1] ?? null;

        $data = [
            'message' => $message,
            'attachment_url' => $image ?? null,
        ];

        $headers = [
            'Authority' => 'www.facebook.com',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Cookie' => $fbAccount->cookie,
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => $fbAccount->user_agent
        ];

        return [
            'url' => $url,
            'data' => $data,
            'headers' => $headers
        ];
    }

}
