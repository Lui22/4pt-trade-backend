<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyRequestDocumentResponse extends JsonResource
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
            "url" => url("storage/buyRequestDocuments/$this->id.$this->extension"),
            "extension" => $this->extension,
            "created_at" => $this->created_at,
        ];
    }
}
