<?php

namespace App\Services\Fb;

use App\Models\FbAccount;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

class FbApi
{
    const HTTP = 'http://';
    const GET = 'GET';
    const POST = 'POST';

    private FbAccount $account;
    private string $proxy;
    private int $timeout = 10;

    public function __construct(FbAccount $account, bool $debug = false)
    {
        $this->account = $account;
    }

    public function setProxy(): void
    {
        $this->proxy = self::HTTP .
            rawurlencode($this->account->proxy->login) .
            ':' .
            rawurlencode($this->account->proxy->password) .
            '@' .
            $this->account->proxy->host .
            ':' .
            $this->account->proxy->port;
    }

    public function sendCurlRequest(string $url, string $method, ?array $data = [], ?array $headers = []): string
    {
        $this->setProxy();

        $curl = Curl::to($url)
            ->withData($data)
            ->withHeaders($headers)
            ->withConnectTimeout($this->timeout)
            ->withOption('PROXY', $this->proxy);

        return  $curl->{strtolower($method)}();
    }

    public function checkAccount(string $url, array $headers): bool
    {
        Log::info('Check fb account ' . $this->account->id);

        $response = $this->sendCurlRequest($url, self::GET, [], $headers);

        $response = json_decode($response, true);

        if ($response['error'] ?? null || !$response) {
            $this->account->is_valid = false;
            $this->account->save();

            Log::info('FbAccount ' . $this->account->id . ' is not valid.');

            return false;
        }

        return true;
    }

    public function getAdAccountId(string $url, array $headers): string
    {
        info('Get adAccount id for account ' . $this->account->id);

        $response = $this->sendCurlRequest($url, self::GET, [], $headers);

          preg_match('/act=[0-9]+/', $response, $adAccountId);

        if (!($adAccountId[0] ?? null)) {
            info('AdAccount id not found for account ' . $this->account->id);
            throw new \Exception('AdAccount id not found');
        }

        return $adAccountId[0];
    }

    public function getAccessToken(string $url, array $headers): string
    {
        info('Get access token for account ' . $this->account->id);

        $response = $this->sendCurlRequest($url, self::GET, [], $headers);

        preg_match('/EAAB[a-zA-Z0-9]+/', $response, $accessToken);

        if (!$accessToken[0] ?? null) {
            info('Access token not found for account ' . $this->account->id);
            throw new \Exception('Access token not found');
        }

        return $accessToken[0];
    }

    public function getPostId(string $url, array $headers, int $postId): string
    {
        info('Get post id for post ' . $postId);

        $response = $this->sendCurlRequest($url, self::GET, [], $headers);

        if (!str_contains($response, 'post_id')) {
            info('Post id not found for post ' . $postId);
            throw new \Exception('Post id not found');
        }

        return explode('"' , substr($response, strpos($response, 'post_id'), 26))[2];
    }

    public function createComment(string $url, array $headers, array $data, int $postId): array
    {
        info('Create comment for post ' . $postId);

        $response = $this->sendCurlRequest($url, self::POST, $data, $headers);

        if (!str_contains($response, 'id')) {
            info('Comment not created for post ' . $postId);
            throw new \Exception('Comment not created');
        }

        return json_decode($response, true);
    }

    public function getPostData(string $url, array $headers): string
    {
        info('Get post data for url ' . $url);

        $response = $this->sendCurlRequest($url, self::GET, [], $headers);

        if (!$response) {
            info('Post data not found for url ' . $url);
            throw new \Exception('Post data not found');
        }

        return $response;
    }

    public function setReaction(string $url, array $headers, array $data, string $postId): void
    {
        info('Set reaction for post ' . $postId);

        $response = $this->sendCurlRequest($url, self::POST, $data, $headers);

        if (!$response) {
            info('Reaction not set for post ' . $postId);
            throw new \Exception('Reaction not set');
        }
    }

    public function createChildComment(string $url, array $headers, array $data, int $postId): array
    {
        info('Create child comment for post ' . $postId);

        $response = $this->sendCurlRequest($url, self::POST, $data, $headers);

        if (!str_contains($response, 'id')) {
            info('Child comment not created for post ' . $postId);
            throw new \Exception('Child comment not created');
        }

        return json_decode($response, true);
    }
}
