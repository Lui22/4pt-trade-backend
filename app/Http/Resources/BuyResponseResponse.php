<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class
BuyResponseResponse extends JsonResource
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
            "supply_at" => $this->supply_at,
            "price" => $this->price,
            "price_with_character" => $this->price . " " . $this->currency->character,
            "currency" => CurrencyListResponse::make($this->currency),
            "price_rub" => $this->price * $this->currency->rubs . " ₽",
            "payment_method" => PaymentMethod::make($this->payment_method),
            "address" => $this->address,
            "status" => BuyResponseStatus::make($this->status),
            "comment" => $this->comment,
            "buy_request" => BuyRequestResponse::make($this->buy_request),
            "documents" => BuyRequestResponseDocumentResponse::collection($this->documents),
            "created_at" => $this->created_at,
        ];
    }
}
