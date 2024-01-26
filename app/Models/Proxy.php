<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proxy extends Model
{
    use HasFactory;

    public function fbAccounts(): BelongsToMany
    {
        return $this->belongsToMany(FbAccount::class, 'fb_account_proxy');
    }
}
