<?php

namespace App\Jobs\Reaction;

use App\Models\Task;
use App\Models\FbPost;
use App\Models\FbAccount;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Services\Fb\FbApiFactory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Comment\UseCases\CheckAccountUseCase;
use App\Jobs\Reaction\UseCases\GenerateDataForGetPostDataUseCase;
use App\Jobs\Reaction\UseCases\GenerateDataForSetReactionUseCase;

class CreateFbReactionsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $taskId
    ) {}

    public function handle(
        FbApiFactory $fbApiFactory,
        CheckAccountUseCase $checkAccountUseCase,
        GenerateDataForGetPostDataUseCase $generateDataForGetPostDataUseCase,
        GenerateDataForSetReactionUseCase $generateDataForSetReactionUseCase,
    ): void
    {
        try {
            $task = Task::query()->findOrFail($this->taskId);
            $post = FbPost::query()->findOrFail($task['post_id']);
            $fbAccount = FbAccount::query()
                ->where('is_valid', true)
                ->inRandomOrder()
                ->first();

            $fbApi = $fbApiFactory->run($fbAccount);

            $checkAccountUseCase->run($fbAccount);

            $data = $generateDataForGetPostDataUseCase->run($fbAccount);
            $response = $fbApi->getPostData($post->url, $data['headers']);

            $data = $generateDataForSetReactionUseCase->run($fbAccount, $response);
            $fbApi->setReaction($data['url'], $data['headers'], $data['data'], $post->id);
        } catch (\Throwable $exception) {
            info($exception->getMessage());
            throw $exception;
        }
    }
}
