<?php

namespace App\Models;

use App\Enums\ItemType;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Timestamp;

    protected $fillable = [
        'name',
        'value',
        'quantity',
        'warning',
        'type',
        'company_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => ItemType::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }

    public function scopeHasStock(Builder $query): void
    {
        $query->where(function (Builder $builder) {
            $builder->where('type', 'product');
            $builder->where('quantity', '>', 0);
        })->orWhere('type', 'service');
    }

    public function scopeIsService(Builder $query): void
    {
        $query->where('type', ItemType::Service);
    }

    public function scopeIsProduct(Builder $query): void
    {
        $query->where('type', ItemType::Product);
    }

    protected function valueFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ '.number_format($this->value, 2, ',', '.'),
        );
    }

    protected function typeFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === ItemType::Product ? 'Produto' : 'Serviço',
        );
    }
}
