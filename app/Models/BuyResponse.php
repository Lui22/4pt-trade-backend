<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyResponse extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "supply_at" => "datetime",
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
        return $this->hasMany(BuyResponseDocument::class);
    }

    public function buy_request(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BuyRequest::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BuyResponseStatus::class, 'buy_response_status_id', 'id');
    }
}
