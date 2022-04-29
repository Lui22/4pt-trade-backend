<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyRequestResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "count" => $this->count,
            "price" => $this->price,
            "price_with_character" => $this->price . " " . $this->currency->character,
            "currency" => CurrencyListResponse::make($this->currency),
            "price_rub" => $this->price * $this->currency->rubs . " ₽",
            "address" => $this->address,
            "production_type" => ProductionType::make($this->production_type),
            "payment_method" => PaymentMethod::make($this->payment_method),
            "is_service" => $this->is_service,
            "user" => UserResponse::make($this->user),
            "is_open" => $this->is_open,
            "is_auction" => $this->is_auction,
            "expiring_at" => $this->expire_at,
            "comment" => $this->comment,
            "documents" => BuyRequestDocumentResponse::collection($this->documents),
            "created_at" => $this->created_at,
        ];
    }
}
