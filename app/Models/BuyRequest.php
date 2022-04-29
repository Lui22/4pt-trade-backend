<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "expire_at" => "datetime",
        'is_service' => 'boolean',
        'is_open' => 'boolean',
        'is_auction' => 'boolean',
    ];

    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function production_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductionType::class);
    }

    public function payment_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BuyRequestDocument::class);
    }

    public function responses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BuyResponse::class);
    }

    public function getPricesAttribute(): float|int
    {
        return $this->price*$this->currency->rubs;
    }
}
