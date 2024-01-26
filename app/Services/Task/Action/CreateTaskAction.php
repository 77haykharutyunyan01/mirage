<?php

namespace App\Services\Task\Action;

use App\Jobs\Comment\CreateFbCommentsJob;
use App\Models\FbComment;
use App\Models\FbPost;
use App\Models\FbReaction;
use App\Models\Task;

use App\Services\Task\Dto\CreateTaskDto;
use Exception;

class CreateTaskAction
{
    public function run(CreateTaskDto $dto): void
    {
        $fbPost = FbPost::query()->create([
                'external_id' => $dto->postId,
                'url' => $dto->postUrl
        ]);

//        $this->saveReactions($dto->postReactionCount, $fbPost->id, false);

        $this->saveComments($dto->postComments, $fbPost->id);
    }

    private function saveComments($comments, $postId, $parentId = null): void
    {
        foreach ($comments as $commentData) {

            $comment = FbComment::query()->create([
                'text' => $commentData['comment'],
                'post_id' => $postId,
                'parent_id' => $parentId,
                'image_url' => $commentData['image_url'] ?? null,
            ]);

//            $this->saveReactions($commentData['reaction_count'], $comment->id,true);

            $this->createTask($postId, $comment, true);

            if (!empty($commentData['answer'])) {
                $this->saveComments($commentData['answer'], $postId, $comment->id);
            }
        }
    }

    private function saveReactions($reactionCount, $modelId, $isComment): void
    {
        for ($i = 0; $i < $reactionCount; $i++) {

            $reaction = FbReaction::staticCreate(
                $modelId,
                $isComment ? FbComment::class : FbPost::class,
            );
            $reaction->save();

            $this->createTask($modelId, $reaction, $isComment);
        }
    }

    private function createTask($postId, $entity, $isComment): void
    {
        if (!is_null($entity?->parent_id)) {
            return;
        }

        $task = [
            'post_id' => $postId,
            'entity_id' => $entity->id,
            'entity_type' => $isComment ? FbComment::class : FbReaction::class,
            'entity_value' => $isComment ? $entity->text .','. $entity->image_url : 'like',
            'status' => 'pending',
            'account_id' => null,
            'parent_id' => $isComment ? $entity->parent_id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $task = Task::query()->insertGetId($task);

        if ($isComment)
            CreateFbCommentsJob::dispatch($task);
            return;
        }

//        CreateFbReactionsJob::dispatch($task);

}
