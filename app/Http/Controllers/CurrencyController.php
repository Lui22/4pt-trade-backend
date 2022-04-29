<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyListResponse;
use App\Models\Currency;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyController extends Controller
{
    public function list(): AnonymousResourceCollection
    {
        return CurrencyListResponse::collection(Currency::all());
    }
}
