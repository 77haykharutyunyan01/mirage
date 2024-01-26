<?php

namespace App\Jobs\Comment;

use App\Models\Task;
use App\Models\FbPost;
use App\Models\FbAccount;
use App\Models\FbComment;
use App\Models\FbReaction;
use App\Services\Fb\FbApi;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Services\Fb\FbApiFactory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Comment\UseCases\CheckAccountUseCase;
use App\Jobs\Comment\UseCases\GenerateDataForGetPostIdUseCase;
use App\Jobs\Comment\UseCases\GenerateDataForCreateCommentUseCase;
use App\Jobs\Comment\UseCases\GenerateDataForGetAccessTokenUseCase;
use App\Jobs\Comment\UseCases\GenerateDataForGetAdAccountIdUseCase;
use App\Jobs\Comment\UseCases\GenerateDataForCheckAccountAccessTokenUseCase;

class CreateFbCommentsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Task $task;
    private FbPost $post;
    private FbApi $fbApi;
    private string $token;
    private string $adAccountId;
    private FbAccount $fbAccount;
    private GenerateDataForGetPostIdUseCase $generateDataForGetPostIdUseCase;
    private GenerateDataForCreateCommentUseCase $generateDataForCreateCommentUseCase;
    private GenerateDataForGetAccessTokenUseCase $generateDataForGetAccessTokenUseCase;
    private GenerateDataForGetAdAccountIdUseCase $generateDataForGetAdAccountIdUseCase;
    private GenerateDataForCheckAccountAccessTokenUseCase $generateDataForCheckAccountAccessTokenUseCase;
    private array $response;

    public function __construct(
        protected int $taskId
    ) {}

    public function handle(
        FbApiFactory                                  $fbApiFactory,
        CheckAccountUseCase                           $checkAccountUseCase,
        GenerateDataForGetPostIdUseCase               $generateDataForGetPostIdUseCase,
        GenerateDataForCreateCommentUseCase           $generateDataForCreateCommentUseCase,
        GenerateDataForGetAccessTokenUseCase          $generateDataForGetAccessTokenUseCase,
        GenerateDataForGetAdAccountIdUseCase          $generateDataForGetAdAccountIdUseCase,
        GenerateDataForCheckAccountAccessTokenUseCase $generateDataForCheckAccountAccessTokenUseCase,
    ): void {
        $this->task = Task::query()->findOrFail($this->taskId);
        $this->post = FbPost::query()->findOrFail($this->task['post_id']);
        $this->fbAccount = FbAccount::query()
            ->where('is_valid', true)
            ->inRandomOrder()
            ->first();

        $this->fbApi = $fbApiFactory->run($this->fbAccount);
        $this->generateDataForGetPostIdUseCase = $generateDataForGetPostIdUseCase;
        $this->generateDataForCreateCommentUseCase = $generateDataForCreateCommentUseCase;
        $this->generateDataForGetAccessTokenUseCase = $generateDataForGetAccessTokenUseCase;
        $this->generateDataForGetAdAccountIdUseCase = $generateDataForGetAdAccountIdUseCase;
        $this->generateDataForCheckAccountAccessTokenUseCase = $generateDataForCheckAccountAccessTokenUseCase;

        $checkAccountUseCase->run($this->fbAccount);


        $this->createComment();

        if ($this->response['id'] ?? null) {
            $this->updateTask();

            $this->updateComment($this->response['id']);

            $this->createTaskForChildComments();
        }
    }

    private function createTask($postId, $comment, $isComment): void
    {
        $task = [
            'post_id' => $postId,
            'entity_id' => $isComment ? $comment->id : null,
            'entity_type' => $isComment ? FbComment::class : FbReaction::class,
            'entity_value' => $isComment ? $comment->text .','. $comment->image_url : 'like',
            'status' => 'pending',
            'account_id' => null,
            'parent_id' => $isComment ? $comment->parent_id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Task::query()->insert($task);

        if ($isComment) {
            CreateFbChildCommentsJob::dispatch(Task::query()->latest()->first()->id);
        }
    }

    private function updateTask(): void
    {
        $this->task['status'] = 'success';
        $this->task['account_id'] = $this->fbAccount->id;
        unset($this->task['created_at']);
        unset($this->task['updated_at']);

        Task::query()->upsert($this->task->toArray(), $this->taskId);
    }

    public function updateComment(string $id): void
    {
        $this->task->comment['external_id'] = $id;
        $this->task->comment->save();
    }

    public function createTaskForChildComments(): void
    {
        foreach ($this->task->comment?->children as $comment) {
            $this->createTask($this->task['post_id'], $comment, true);
        }
    }

    public function createComment(): void
    {
        $data = $this->generateDataForGetPostIdUseCase->run($this->fbAccount);
        $postId = $this->fbApi->getPostId($this->post->url, $data['headers'], $this->post->id);

        $data = $this->generateDataForCreateCommentUseCase->run(
            $this->fbAccount,
            $postId,
            $this->post->external_id,
            $this->task['entity_value']
        );
        $this->response = $this->fbApi->createComment($data['url'], $data['headers'], $data['data'], $this->post->id);
    }
}
