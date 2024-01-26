<?php

namespace App\Jobs\Reaction\UseCases;

use App\Models\FbAccount;

class GenerateDataForSetReactionUseCase
{
    public function run(FbAccount $fbAccount, string $response): array
    {
        $url = 'https://www.facebook.com/api/graphql/';

        $reactionId = ['1635855486666999', '1678524932434102', '613557422527858', '478547315650144'];

        $parsedData = explode('"', substr($response, strpos($response, 'DTSGInitialData'), 170));
        $userFacebookId = explode('"', substr($response, strpos($response, 'USER_ID'), 26))[2];
        $feedbackId = explode('"', substr($response, strpos($response, '{"feedback":{"id":"'), 52))[5];
        $fbdtsg = $parsedData[4];
        $lsd = $parsedData[12];

        $data = [
            'av' => $userFacebookId,
            'fb_dtsg' => $fbdtsg,
            'lsd' => $lsd,
            'variables' => '{"input":{"feedback_id":"' . $feedbackId . '","feedback_reaction_id":"' . $reactionId[array_rand($reactionId)] . '","feedback_source":"OBJECT","is_tracking_encrypted":true,"actor_id":"' . $userFacebookId . '","client_mutation_id":"1"},"scale":2}',
            'doc_id' => '6880473321999695'
        ];

        $headers = [
            'Host' => 'www.facebook.com',
            'Authority' => 'www.facebook.com',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Cookie' => $fbAccount->cookie,
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => $fbAccount->user_agent,
        ];

        return [
            'url' => $url,
            'data' => $data,
            'headers' => $headers
        ];
    }

}
