<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            'lastname' => $this->lastname,
            'middlename' => $this->middlename,
            'login' => $this->login,
            'telephone' => $this->telephone,
            'INN' => $this->INN,
            'OGRN' => $this->OGRN,
            'address' => $this->address,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'role' => $this->role->name,
        ];
    }
}
