<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\StoreBuyRequestRequest;
use App\Http\Requests\UpdateBuyRequestRequest;
use App\Http\Resources\BuyRequestResponse;
use App\Http\Resources\BuyRequestShowResponse;
use App\Models\BuyRequest;
use App\Models\BuyRequestDocument;
use App\Models\BuyResponse;
use App\Models\Currency;
use App\Models\ProductionType;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BuyRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $this->checkExpired();

        return BuyRequestResponse::collection(BuyRequest::where('is_open', true)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBuyRequestRequest $request
     * @return BuyRequestResponse
     */
    public function store(StoreBuyRequestRequest $request)
    {
        $data = [
            "user_id" => Auth::id(),
            "is_open" => true,
            "address" => "Самовывоз",
        ];

        if ($request->production_type_name) {
            $data["production_type_id"] = ProductionType::create(["name" => $request->production_type_name])->id;
        }

        $buyRequest = BuyRequest::create(
            array_merge(
                $data,
                $request->only(
                    'name',
                    'count',
                    'currency_id',
                    'expire_at',
                    'production_type_id',
                    'payment_method_id',
                    'address',
                    'user_id',
                    'comment',
                    'is_service',
                    'price',
                    'is_auction'
                ),
            )
        );

        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $file) {
                $document = BuyRequestDocument::create([
                    "buy_request_id" => $buyRequest->id,
                    "extension" => $file->extension(),
                ]);

                $file->storePubliclyAs('buyRequestDocuments', $document->id . '.' . $file->extension());
            }
        }

        return BuyRequestResponse::make($buyRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param BuyRequest $buyRequest
     * @return BuyRequestShowResponse
     */
    public function show(BuyRequest $request)
    {
        return BuyRequestShowResponse::make($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBuyRequestRequest $updateBuyRequestRequest
     * @param BuyRequest $buyRequest
     * @return BuyRequestResponse|Application|ResponseFactory|Response
     */
    public function update(UpdateBuyRequestRequest $updateBuyRequestRequest, BuyRequest $request)
    {
        if (($updateBuyRequestRequest->price || $updateBuyRequestRequest->currency_id) && $request->is_open) {
            return \response([
                "message" => "Попытка изменить цену на открытой сделке",
            ], 422);
        }

        $request->update(
            $updateBuyRequestRequest->only(
                'name',
                'count',
                'currency_id',
                'expire_at',
                'production_type_id',
                'payment_method_id',
                'address',
                'user_id',
                'comment',
                'is_service',
                'price',
                'is_auction'
            ),
        );
        $request->save();

        return BuyRequestResponse::make($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BuyRequest $buyRequest
     * @return Response
     */
    public function destroy(BuyRequest $request)
    {
        if ($request->user() === Auth::user() && !$request->is_open) {
            $request->delete();
        }

        return \response([
            "message" => "deleted"
        ]);
    }

    public function checkExpired()
    {
        $requests = BuyRequest::where('is_open', true)->get();
        foreach ($requests as $request) {
            if ($request->expire_at != null && Carbon::now() > $request->expire_at) {
                $request->is_open = false;
                $request->save();

                if ($request->is_auction) {
                    $lowest = $this->cheapestResponseByRequestId($request->id);
                    $this->win($request, $lowest);
                }
            }
        }

        return "sosa";
    }

    public function close(BuyRequest $request)
    {
        if (!$request->is_open) {
            return \response([
                "message" => "Уже закрыта"
            ], 422);
        }

        $request->is_open = false;
        $request->save();

        return $request;
    }

    public function open(BuyRequest $request)
    {
        if ($request->is_open) {
            return \response([
                "message" => "Уже открыта"
            ], 422);
        }

        $request->is_open = true;
        $request->responses()->delete();
        $request->save();

        return $request;
    }

    public function filter(ApiRequest $request)
    {
        $scope = [];

        $scope[] = ['is_open', true];
//        if ($request->price_from) $scope[] = ['price', '>=', $request->price_from];
//        if ($request->price_to) $scope[] = ['price', '<=', $request->price_to];
        if ($request->date_from) $scope[] = ['created_at', '>=', Carbon::make($request->date_from)->toDateTime()];
        if ($request->date_to) $scope[] = ['created_at', '<=', Carbon::make($request->date_to)->toDateTime()];

        $scopedRequests = BuyRequest::where($scope);
        if ($request->purchaser_id) $scopedRequests->whereIn('user_id', $request->purchaser_id);
        if ($request->production_id) $scopedRequests->whereIn('production_type_id', $request->production_id);

        return $scopedRequests->get();
    }

    public static function cheapestResponseByRequestId($id)
    {
        $sorted = BuyResponse::where('buy_request_id', $id)->get()
            ->sortBy(function ($request, $key) {
                return Currency::find($request->currency_id)->rubs * $request->price;
            });

        return collect($sorted)->first();
    }

    public static function win(BuyRequest $buyRequest, BuyResponse $wonResponse)
    {
        $buyRequest->is_open = false;
        $buyRequest->save();

        BuyResponse::where('buy_request_id', $buyRequest->id)->get()
            ->each(function ($item, $key) {
                $item->buy_response_status_id = 1;
                $item->save();
            });

        $wonResponse->buy_response_status_id = 2;
        $wonResponse->save();

        BuyResponseNotificationController::notify($wonResponse->user_id);
    }
}
