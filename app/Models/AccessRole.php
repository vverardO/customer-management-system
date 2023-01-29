<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessRole extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function scopeIsAdmin($query): Builder
    {
        return $query->where('title', 'Administrador');
    }

    public function scopeIsUser($query): Builder
    {
        return $query->where('title', 'Usuário');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
