<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyResponseShowResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
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
