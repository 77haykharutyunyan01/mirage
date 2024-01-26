<?php

namespace App\Models\Company;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use App\Services\Company\Dto\CreateCompanyDto;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Company/Company
 *
 * @property string $id;
 * @property string $owner_id;
 * @property string $name;
 * @property string $status;
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'owner_id'
    ];

    public static function staticCreate(CreateCompanyDto $dto): Company
    {
        $company = new Company();

        $company->setName($dto->name);
        $company->setStatus($dto->status);
        $company->setOwnerId($dto->ownerId);

        return $company;
    }

    public function setOwnerId(string $ownerId): void
    {
        $this->owner_id = $ownerId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_companies',
            'company_id',
            'user_id'
        )->withTimestamps();
    }

    public function domains(): BelongsToMany
    {
        return $this->belongsToMany(
            Domain::class,
            'domain_companies',
            'company_id',
            'domain_id'
        )->withTimestamps();
    }

    public function owner(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id',
            'owner_id'
        );
    }
}
