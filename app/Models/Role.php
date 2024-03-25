<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Role extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $fillable = ['uuid', 'role', 'created_at', 'updated_at'];
    protected $table = 'role';
    public $timestamps = true;

    protected static function booted()
    {
        static::creating(fn(Role $role) => $role->id = (string) Uuid::uuid4());
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
