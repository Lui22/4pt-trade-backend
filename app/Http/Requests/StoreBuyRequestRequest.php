<?php

namespace App\Http\Requests;

use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\ProductionType;
use Illuminate\Validation\Rule;

class StoreBuyRequestRequest extends ApiRequest
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
            "name" => "required",
            "count" => "required",
            "price" => "required",
            "currency_id" => [
                "required",
                Rule::exists(Currency::class, 'id')
            ],
            "expire_at" => "date|after:now",
            "production_type_id" => [
                Rule::exists(ProductionType::class, 'id')
            ],
            "address" => "",
            "comment" => "",
            "is_service" => "required|boolean",
            "payment_method_id" => [
                "required",
                Rule::exists(PaymentMethod::class, 'id')
            ],
            "document" => ""
        ];
    }
}
