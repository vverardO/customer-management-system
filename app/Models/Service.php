<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Timestamp;

    protected $fillable = [
        'name',
        'value',
        'company_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }

    protected function valueFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->value, 2, ',', '.'),
        );
    }
}
