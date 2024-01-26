<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    const ID = 'id';
    const URL = 'url';
    const POST = 'post';
    const IMAGE_URL = 'image_url';
    const ANSWER = 'answer';
    const COMMENT = 'comment';
    const COMMENTS = 'comments';
    const REACTION_COUNT = 'reaction_count';

    public function rules(): array
    {
        return [
            self::POST => 'required|array',
            self::POST .'.'. self::ID => 'required|integer',
            self::POST .'.'. self::URL => 'required|string',
            self::POST .'.'. self::IMAGE_URL => 'nullable|string',
            self::POST .'.'. self::REACTION_COUNT => 'nullable|integer',
            self::POST .'.'. self::COMMENTS => 'required|array',
            self::POST .'.'. self::COMMENTS .'.'. self::REACTION_COUNT => 'nullable|integer',
            self::POST .'.'. self::COMMENTS .'.'. self::ANSWER => 'nullable|array',
            self::POST .'.'. self::COMMENTS .'.'. self::ANSWER .'.'. self::COMMENT => 'nullable|string',
            self::POST .'.'. self::COMMENTS .'.'. self::ANSWER .'.'. self::REACTION_COUNT => 'nullable|integer',
        ];
    }

    public function getPost(): array
    {
        return $this->get(self::POST);
    }

    public function getPostId(): int
    {
        return $this->getPost()[self::ID];
    }

    public function getPostUrl(): string
    {
        return $this->getPost()[self::URL];
    }

    public function getImageUrl(): ?string
    {
        return $this->getPost()[self::IMAGE_URL] ?? null;
    }

    public function getPostReactionCount(): ?int
    {
        return $this->getPost()[self::REACTION_COUNT] ?? null;
    }

    public function getPostComments(): array
    {
        return $this->getPost()[self::COMMENTS];
    }
}
