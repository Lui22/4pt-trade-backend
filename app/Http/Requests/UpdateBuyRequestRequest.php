<?php

namespace App\Http\Requests;

use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\ProductionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBuyRequestRequest extends ApiRequest
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
            "name" => "",
            "count" => "",
            "price" => "",
            "currency_id" => [
                Rule::exists(Currency::class, 'id')
            ],
            "expire_at" => "date|after:now",
            "production_type_id" => [
                Rule::exists(ProductionType::class, 'id')
            ],
            "address" => "",
            "comment" => "",
            "is_service" => "boolean",
            "payment_method_id" => [
                Rule::exists(PaymentMethod::class, 'id')
            ],
            "document" => ""
        ];
    }
}
