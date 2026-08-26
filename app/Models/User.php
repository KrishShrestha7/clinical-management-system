<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    /**
 * Determine whether the user has the given role.
 */
    public function hasRole(UserRole $role): bool
    {
        return $this->role === $role;
    }

    /**
 * Determine whether the user is an administrator.
 */
    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::ADMIN);
    }

    public function isDoctor(): bool
    {
        return $this->hasRole(UserRole::DOCTOR);
    }

    public function isReceptionist(): bool
    {
        return $this->hasRole(UserRole::RECEPTIONIST);
    }

    public function isPatient(): bool
    {
        return $this->hasRole(UserRole::PATIENT);
    }

    /**
 * Get the patient profile associated with the user.
 */
    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }
}
