<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FbPost
 *
 * @property int $id
 * @property string $external_id
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 */
class FbPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'url',
    ];

    public function setExternalId(string $externalId): void
    {
        $this->external_id = $externalId;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
