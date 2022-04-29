<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BuyResponseShowResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "supply_at" => $this->supply_at,
            "price" => $this->price,
            "price_with_character" => $this->price." ".$this->currency->character,
            "currency" => CurrencyListResponse::make($this->currency),
            "price_rub" => $this->price*$this->currency->rubs." ₽",
            "payment_method" => PaymentMethod::make($this->payment_method),
            "address" => $this->address,
            "status" => BuyResponseStatus::make($this->status),
            "documents" => BuyRequestResponseDocumentResponse::collection($this->documents),
            "comment" => $this->comment,
            "user" => UserResponse::make($this->user),
            "created_at" => $this->created_at,
        ];
    }
}
