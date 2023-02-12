<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemOrder extends Pivot
{
    protected $fillable = [
        'value',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Item::class)->isProduct();
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Item::class)->isService();
    }

    protected function valueFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ '.number_format($this->value, 2, ',', '.'),
        );
    }
}
