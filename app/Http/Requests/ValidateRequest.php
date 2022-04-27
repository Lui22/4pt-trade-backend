<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class ValidateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "login" => [
                Rule::unique(User::class),
            ],
            "email" => [
                Rule::unique(User::class),
                "email"
            ],
            "INN" => [
                Rule::unique(User::class),
                "min:10"
            ],
            "OGRN" => [
                Rule::unique(User::class),
                "size:14"
            ],
        ];
    }
}
