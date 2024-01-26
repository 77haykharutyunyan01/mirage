<?php

namespace App\Services\Task\Dto;

use App\Http\Requests\CreateTaskRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateTaskDto extends DataTransferObject
{
    public array $post;
    public int $postId;
    public ?string $imageUrl;
    public string $postUrl;
    public ?int $postReactionCount;
    public array $postComments;

    public static function fromRequest(CreateTaskRequest $request): CreateTaskDto
    {
        return new self(
            post: $request->getPost(),
            postId: $request->getPostId(),
            postUrl: $request->getPostUrl(),
            imageUrl: $request->getImageUrl(),
            postReactionCount: $request->getPostReactionCount(),
            postComments: $request->getPostComments(),
        );
    }

}
