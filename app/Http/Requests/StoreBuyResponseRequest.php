<?php

namespace App\Http\Requests;

use App\Models\BuyRequest;
use App\Models\BuyResponse;
use App\Models\Currency;
use App\Models\PaymentMethod;
use Illuminate\Validation\Rule;

class StoreBuyResponseRequest extends ApiRequest
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
            "buy_request_id" => [
                "required",
                Rule::exists(BuyRequest::class, 'id')->where('is_open', true)
            ],
            "supply_at" => "date|after:now",
            "currency_id" => [
                "required_with:price",
                Rule::exists(Currency::class, 'id')
            ],
            "price" => "required_with:currency_id|numeric|min:0.01",
            "address" => "",
            "comment" => "",
            "payment_method_id" => [
                Rule::exists(PaymentMethod::class, 'id')
            ],
            "document" => ""
        ];
    }
}
