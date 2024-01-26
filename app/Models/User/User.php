<?php

namespace App\Models\User;

use Illuminate\Support\Str;
use App\Models\Company\Company;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * App\Models\Auth
 *
 * @property string $id;
 * @property string $name;
 * @property string $email;
 * @property string $password;
 * @property string $status;
 * @property string $api_key;
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    const ACTIVE = 'active';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    protected string|array $guard_name = 'api';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function staticCreate(CreateUserDto $dto): User
    {
        $user = new self();

        $user->setName($dto->name);
        $user->setEmail($dto->email);
        $user->setPassword($dto->password);
        $user->setStatus($dto->status ?? self::ACTIVE);

        $user->assignRole($dto->role);

        return $user;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = bcrypt($password);
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function setApiKey(): void
    {
        $this->api_key = Str::random(50);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(
            Company::class,
            'user_companies',
            'user_id',
            'company_id'
        )->withTimestamps();
    }
}
