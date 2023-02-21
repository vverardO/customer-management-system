<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'address_id',
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

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->isService()
            ->withPivot(['value'])
            ->using(ItemOrder::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->isProduct()
            ->withPivot(['value'])
            ->using(ItemOrder::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->withPivot(['value'])
            ->using(ItemOrder::class);
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

    protected function hasAttendance(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->address ? 'Sim' : 'Não',
        );
    }

    protected function totalValueFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->total_value, 2, ',', '.'),
        );
    }
}
