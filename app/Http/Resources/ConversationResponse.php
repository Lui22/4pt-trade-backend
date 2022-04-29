<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ConversationResponse extends JsonResource
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
            "last_message" => Message::where('buy_response_id', $this->id)->orderBy('created_at', 'desc')->first()?->message,
            "buy_response" => BuyResponseResponse::make($this)
        ];
    }
}
