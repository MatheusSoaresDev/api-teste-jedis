<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Produto extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $table = 'produtos';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'nome',
        'descricao',
        'preco',
        'quantidade',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'compra', 'produto_id', 'user_id');
    }
}
