<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Casts\Attribute;
 
class OrderService extends Pivot
{
    protected $fillable = [
        'value',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    protected function valueFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => "R$ ".number_format($this->value, 2, ',', '.'),
        );
    }
}