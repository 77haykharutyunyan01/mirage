<?php

namespace App\Jobs\Comment\UseCases;

use App\Models\FbAccount;

class GenerateDataForCreateCommentUseCase
{
    public function run(FbAccount $fbAccount, string $postId, $pageId, string $taskValue): array
    {
        $url  = 'https://graph.facebook.com/v18.0/' . $pageId . '_' . $postId .'/comments?access_token=' . $fbAccount->token;

        $headers = [
            'Authority' => 'www.facebook.com',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Cookie' => $fbAccount->cookie,
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => $fbAccount->user_agent,
        ];

        $message = explode(',', $taskValue)[0];
        $image = explode(',', $taskValue)[1] ?? null;

        $data = [
            'message' => $message,
            'attachment_url' => $image ?? null,
        ];

        return [
            'url' => $url,
            'headers' => $headers,
            'data' => $data,
        ];
    }
}
