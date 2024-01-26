<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\FbComment
 *
 * @property string $id
 * @property string $text
 * @property string $post_id
 * @property string $image_url
 * @property string $parent_id
 * @property string $account_id
 * @property string $created_at
 * @property string $updated_at
 */
class FbComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'post_id',
        'image_url',
        'parent_id',
        'account_id',
    ];

    public static function staticCreate(
        string $text,
        string $postId,
        ?string $parentId,
        string $imageUrl = null,
    ): static {
        $fbComment = new static();
        $fbComment->setText($text);
        $fbComment->setPostId($postId);
        $fbComment->setImageUrl($imageUrl);
        $fbComment->setParentId($parentId);

        return $fbComment;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setPostId(string $postId): void
    {
        $this->post_id = $postId;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->image_url = $imageUrl;
    }

    public function setParentId(?string $parentId): void
    {
        $this->parent_id = $parentId;
    }

    public function setAccountId(string $accountId): void
    {
        $this->account_id = $accountId;
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(FbPost::class, 'post_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(FbAccount::class, 'account_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FbComment::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FbComment::class, 'parent_id');
    }
}
