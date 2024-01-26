<?php

namespace App\Console\Commands;

use App\Jobs\Comment\CreateFbCommentsJob;
use App\Jobs\Reaction\CreateFbReactionsJob;
use App\Models\FbComment;
use App\Models\FbPost;
use App\Models\FbReaction;
use App\Models\Task;
use Illuminate\Console\Command;

class CommentPublishCommand extends Command
{
    protected $signature = 'app:comment-publish-command';

    protected $description = 'Command description';


    public function handle(): void
    {
        $post = FbPost::create([
            'external_id' => 100070051386373,
            'url' => 'https://www.facebook.com/permalink.php?story_fbid=pfbid038fcN8aWQcCrHcHu5pUrvZ1QLX982tfeoqo4cMLJG4t5wv7hofEjmc3pgyUxWzEzl&id=100070051386373'
        ]);

        $this->saveReactions(5, $post->id, false);

        $comments = [
            [
                'comment' => '111',
                'image_url' => null
            ],
            [
                'comment' => '222',
                'image_url' => null
            ],
            [
                'comment' => '333',
                'image_url' => null
            ],
            [
                'comment' => '444',
                'image_url' => null
            ],
            [
                'comment' => '555',
                'image_url' => null
            ],
        ];

        $this->saveComments($comments, $post->id);
    }

    private function saveReactions($reactionCount, $modelId, $isComment): void
    {
        for ($i = 0; $i < $reactionCount; $i++) {
            $reaction = FbReaction::staticCreate($modelId, FbReaction::class);
            $reaction->save();

            $this->createTask($modelId, $reaction, false);
        }
    }

    private function createTask($postId, $entity, $isComment): void
    {
        if (!is_null($entity?->parent_id)) {
            return;
        }

        $task = [
            'post_id' => $postId,
            'entity_id' =>  $entity->id,
            'entity_type' => $isComment ? FbComment::class : FbReaction::class,
            'entity_value' => $isComment ? $entity->text .','. $entity->image_url : 'like',
            'status' => 'pending',
            'account_id' => null,
            'parent_id' => $isComment ? $entity->parent_id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $task = Task::query()->insertGetId($task);

        if ($isComment) {
            CreateFbCommentsJob::dispatch($task);
            return;
        }
        CreateFbReactionsJob::dispatch($task);
    }

    private function saveComments($comments, $postId, $parentId = null): void
    {
        foreach ($comments as $commentData) {
            $comment = FbComment::create([
                'text' => $commentData['comment'],
                'post_id' => $postId,
                'parent_id' => $parentId,
                'image_url' => $commentData['image_url'] ?? null,
            ]);

            $this->createTask($postId, $comment, true);

            if (!empty($commentData['answer'])) {
                $this->saveComments($commentData['answer'], $postId, $comment->id);
            }
        }
    }
}
