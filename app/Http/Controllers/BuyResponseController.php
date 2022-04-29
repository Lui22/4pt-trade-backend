<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\StoreBuyResponseRequest;
use App\Http\Requests\UpdateBuyResponseRequest;
use App\Http\Resources\BuyResponseResponse;
use App\Models\BuyRequest;
use App\Models\BuyResponse;
use App\Models\Currency;
use App\Models\Message;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use function response;

class BuyResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return BuyResponseResponse::collection(BuyResponse::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBuyResponseRequest $request
     * @return BuyResponseResponse
     */
    public function store(StoreBuyResponseRequest $request): BuyResponseResponse
    {
        $data = [];

        $oldResponse = BuyResponse::where([
            'user_id' => Auth::id(),
            'buy_request_id' => $request->buy_request_id
        ])->orderBy('created_at', 'desc')->first();

        $buyRequest = BuyRequest::find($request->buy_request_id);
        $data['production_type_id'] = $buyRequest->production_type_id;
        if (!$request->currency_id) $data['currency_id'] = $buyRequest->currency_id;
        if (!$request->payment_method_id) $data['payment_method_id'] = $buyRequest->payment_method_id;
        if (!$request->address) $data['address'] = "Самовывоз";
        $data['user_id'] = Auth::id();
        $data['buy_response_status_id'] = 3;

        if ($request->price) {
            if (!$buyRequest->is_auction) {
                throw new HttpResponseException(response([
                    "message" => "Попытка установить цену на фикс. сделке"
                ], 422));
            } else {
                $requestPrice = $request->price * Currency::find($request->currency_id)->rubs;
                $originalPrice = $buyRequest->price * $buyRequest->currency()->first()->rubs;

                $cheapest = BuyRequestController::cheapestResponseByRequestId($buyRequest->id);
                $lowestPrice = $cheapest?->price * $cheapest?->currency()?->first()?->rubs;

                if ($requestPrice >= $originalPrice) {
                    throw new HttpResponseException(response([
                        "message" => "Попытка установить цену выше начальной",
                    ], 422));
                }

                if ($lowestPrice && $requestPrice >= $lowestPrice) {
                    throw new HttpResponseException(response([
                        "message" => "Попытка установить цену выше текущей минимальной",
                        "minimal" => $lowestPrice,
                        "requestes" => $requestPrice //Todo: переименовать в requested
                    ], 422));
                }

                $data['price'] = $request->price;
            }
        } else {
            $data['price'] = $buyRequest->price;
        }

        $buyResponse = BuyResponse::create(array_merge(
            $data,
            $request->only(
                'buy_request_id',
                'supply_at',
                'price',
                'currency_id',
                'payment_method_id',
                'address',
                'comment',
            )
        ));

        $oldMessages = Message::where([
            'user_id' => Auth::id(),
            "buy_response_id" => $oldResponse?->id,
        ])->get();

        if ($oldMessages) {

            foreach ($oldMessages as $oldMessage) {
                $message = Message::find($oldMessage->id);
                $message->buy_response_id = $buyResponse->id;
                $message->save();
            }
        }

        return BuyResponseResponse::make($buyResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param BuyResponse $buyResponse
     * @return void
     */
    public function show(BuyResponse $buyResponse): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBuyResponseRequest $request
     * @param BuyResponse $buyResponse
     * @return void
     */
    public function update(UpdateBuyResponseRequest $request, BuyResponse $buyResponse): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BuyResponse $buyResponse
     * @return void
     */
    public function destroy(BuyResponse $buyResponse): void
    {
        //
    }


    public function changeStatus(ApiRequest $request, BuyResponse $buyResponse): BuyResponse
    {
        $buyResponse->buy_response_status_id = $request->status_id;

        if ($request->status_id == 2) {
            $buyRequest = BuyRequest::find($buyResponse->buy_request_id);
            BuyRequestController::win($buyRequest, $buyResponse);
        }

        return $buyResponse;
    }
}
