<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;
    use Timestamp;
    use HasFactory;

    protected $fillable = [
        'title',
        'number',
        'description',
        'total_value',
        'company_id',
        'customer_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }

    protected function descriptionLimited(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->description, 50),
        );
    }

    protected function totalValueFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->total_value, 2, ',', '.'),
        );
    }
}
