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

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function production_type()
    {
        return $this->belongsTo(ProductionType::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(BuyRequestDocument::class);
    }

    public function responses()
    {
        return $this->hasMany(BuyResponse::class);
    }

    public function getPricesAttribute()
    {
        return $this->price*$this->currency->rubs;
    }
}
