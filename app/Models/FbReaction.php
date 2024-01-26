<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\FbReactions
 *
 * @property string $id
 * @property string $model_id
 * @property string $model_type
 * @property string $account_id
 * @property string $external_id
 * @property string $created_at
 * @property string $updated_at
 */
class FbReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'account_id',
        'external_id',
    ];

    public static function staticCreate(
        string $model_id,
        string $model_type,
    ): static {
        $fbReaction = new static();
        $fbReaction->setModelId($model_id);
        $fbReaction->setModelType($model_type);

        return $fbReaction;
    }

    public function setAccountId(string $accountId): void
    {
        $this->account_id = $accountId;
    }

    public function setModelId(string $model_id): void
    {
        $this->model_id = $model_id;
    }

    public function setModelType(string $model_type): void
    {
        $this->model_type = $model_type;
    }

    public function setExternalId(string $external_id): void
    {
        $this->external_id = $external_id;
    }
}
