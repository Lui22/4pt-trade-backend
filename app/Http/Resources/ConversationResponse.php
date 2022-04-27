<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResponse extends JsonResource
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
            "last_message" => Message::where('buy_response_id', $this->id)->orderBy('created_at', 'desc')->first()?->message,
            "buy_response" => BuyResponseResponse::make($this)
        ];
    }
}
