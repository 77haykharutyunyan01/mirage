<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
    * App\Models\FbAccount
    * @property Proxy $proxy;
 */
class FbAccount extends Model
{
    use HasFactory;

    public function proxy(): BelongsTo
    {
        return $this->belongsTo(Proxy::class, 'proxy_id');
    }
}
