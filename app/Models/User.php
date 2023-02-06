<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Timestamp;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'access_role_id',
        'company_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function accessRole(): BelongsTo
    {
        return $this->belongsTo(AccessRole::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }
}
