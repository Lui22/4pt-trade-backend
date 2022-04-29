<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BuyRequestResponseDocumentResponse extends JsonResource
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
            "url" => url("storage/buyResponseDocuments/$this->id.$this->extension"),
            "extension" => $this->extension,
            "created_at" => $this->created_at,
        ];
    }
}
