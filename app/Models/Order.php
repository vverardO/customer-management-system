<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'identificator',
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
