<?php

namespace App\Jobs\Comment\UseCases;

use App\Models\FbAccount;
use App\Services\Fb\FbApi;
use App\Services\Fb\FbApiFactory;
use Throwable;

class CheckAccountUseCase
{
    private FbApi $fbApi;
    private string $token;
    private FbAccount $fbAccount;

    public function __construct(
        public FbApiFactory $fbApiFactory,
        public GenerateDataForGetAccessTokenUseCase $generateDataForGetAccessTokenUseCase,
        public GenerateDataForGetAdAccountIdUseCase $generateDataForGetAdAccountIdUseCase,
        public GenerateDataForCheckAccountAccessTokenUseCase $generateDataForCheckAccountAccessTokenUseCase
    ) {}

    public function run(FbAccount $fbAccount): void
    {
        $this->fbApi = $this->fbApiFactory->run($fbAccount);
        $this->fbAccount = $fbAccount;

        $this->checkAccount();
    }

    private function checkAccount(): void
    {
        $data = $this->generateDataForCheckAccountAccessTokenUseCase->run($this->fbAccount);

        $isValid = $this->fbApi->checkAccount($data['url'], $data['headers']);

        if (!$isValid) {
            $this->getAccessToken();

            $this->changeAccountAccessToken();
        }

    }

    private function getAccessToken(): void
    {
        try {
            $data = $this->generateDataForGetAdAccountIdUseCase->run($this->fbAccount);
            $adAccountId = $this->fbApi->getAdAccountId($data['url'], $data['headers']);

            $data = $this->generateDataForGetAccessTokenUseCase->run($this->fbAccount, $adAccountId);

            $this->token = $this->fbApi->getAccessToken($data['url'], $data['headers']);
        } catch (Throwable $exception) {
            info($exception->getMessage());
            throw $exception;
        }
    }

    private function changeAccountAccessToken(): void
    {
        $this->fbAccount->token = $this->token;
        $this->fbAccount->is_valid = true;
        $this->fbAccount->save();
    }
}
