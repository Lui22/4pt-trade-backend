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
        return $this->hasMany(BuyResponseDocument::class);
    }

    public function buy_request()
    {
        return $this->belongsTo(BuyRequest::class);
    }

    public function status()
    {
        return $this->belongsTo(BuyResponseStatus::class, 'buy_response_status_id', 'id');
    }
}
