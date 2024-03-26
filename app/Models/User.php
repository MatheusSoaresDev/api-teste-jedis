<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const DEFAULT_ROLE = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    protected $attributes = [
        'role' => self::DEFAULT_ROLE,
    ];

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'role', 'role');
    }

    public function compras(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class);
    }
}
