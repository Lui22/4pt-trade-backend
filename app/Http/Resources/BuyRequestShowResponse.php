<?php

namespace App\Http\Resources;

use App\Http\Controllers\BuyRequestController;
use App\Models\BuyResponse;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BuyRequestShowResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $cheapestResponse = BuyRequestController::cheapestResponseByRequestId($this->id);

        $lowest_price = null;
        if ($cheapestResponse) {
            $lowest_price = $cheapestResponse->price." ".$cheapestResponse?->currency->character;
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "count" => $this->count,
            "price" => $this->price,
            "price_with_character" => $this->price." ".$this->currency->character,
            "currency" => CurrencyListResponse::make($this->currency),
            "price_rub" => $this->price*$this->currency->rubs." ₽",
            "address" => $this->address,
            "production_type" => ProductionType::make($this->production_type),
            "payment_method" => PaymentMethod::make($this->payment_method),
            "is_service" => $this->is_service,
            "user" => UserResponse::make($this->user),
            "is_auction" => $this->is_auction,
            "is_open" => $this->is_open,
            "expiring_at" => $this->expire_at,
            "comment" => $this->comment,
            "documents" => BuyRequestDocumentResponse::collection($this->documents),
            "responses" => BuyResponseShowResponse::collection(BuyResponse::where('buy_request_id', $this->id)->get()),
            "lowest_price" => $lowest_price,
            "created_at" => $this->created_at,
        ];
    }
}
