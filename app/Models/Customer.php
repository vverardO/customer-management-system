<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Timestamp;

    protected $fillable = [
        'name',
        'general_record',
        'registration_physical_person',
        'company_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
