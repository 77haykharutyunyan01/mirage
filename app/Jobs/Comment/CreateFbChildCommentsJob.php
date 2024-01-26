<?php

namespace App\Jobs\Comment;

use App\Models\Task;
use App\Models\FbAccount;
use App\Models\FbComment;
use App\Services\Fb\FbApi;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Services\Fb\FbApiFactory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Comment\UseCases\CheckAccountUseCase;
use App\Jobs\Comment\UseCases\GenerateDataForCreateChildCommentUseCase;

class CreateFbChildCommentsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Task $task;
    private FbApi $fbApi;
    private array $response;
    private FbAccount $fbAccount;
    private GenerateDataForCreateChildCommentUseCase $generateDataForCreateChildCommentUseCase;

    public function __construct(
        protected int $taskId,
    ) {}

    public function handle(
        FbApiFactory $fbApiFactory,
        CheckAccountUseCase $checkAccountUseCase,
        GenerateDataForCreateChildCommentUseCase $generateDataForCreateChildCommentUseCase,
    ): void {
        $this->generateDataForCreateChildCommentUseCase = $generateDataForCreateChildCommentUseCase;
        $this->fbAccount = FbAccount::query()
            ->where('is_valid', true)
            ->inRandomOrder()
            ->first();
        $this->task = Task::query()->findOrFail($this->taskId);
        $this->fbApi = $fbApiFactory->run($this->fbAccount);

        $checkAccountUseCase->run($this->fbAccount);

        $this->createChildComment();

        $this->updateTask();

        $this->updateComment();

        $this->createTaskForChildComments();
    }

    private function createTask($postId, $comment): void
    {
        $task = [
            'post_id' => $postId,
            'entity_id' => $comment->id,
            'entity_type' => FbComment::class,
            'entity_value' => $comment->text . ',' . $comment->image_url,
            'status' => 'pending',
            'account_id' => null,
            'parent_id' => $comment->parent_id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $taskId = Task::query()->insertGetId($task);

        CreateFbChildCommentsJob::dispatch($taskId);
    }

    private function createChildComment(): void
    {
        $parentId = $this->task->comment?->parent->external_id;

        $data = $this->generateDataForCreateChildCommentUseCase->run($this->fbAccount, $parentId, $this->task['entity_value']);
        $this->response = $this->fbApi->createChildComment($data['url'], $data['headers'], $data['data'], $this->task['post_id']);
    }

    private function updateTask(): void
    {
        $this->task['status'] = 'success';
        $this->task['account_id'] = $this->fbAccount->id;
        unset($this->task['created_at']);
        unset($this->task['updated_at']);
        unset($this->task['comment']);

        Task::query()->upsert($this->task->toArray(), $this->taskId);
    }

    public function updateComment(): void
    {
        $this->task->comment['external_id'] = $this->response['id'];
        $this->task->comment->save();
    }

    public function createTaskForChildComments(): void
    {
        foreach ($this->task->comment?->children as $comment) {
            $this->createTask($this->task['post_id'], $comment);
        }
    }
}
