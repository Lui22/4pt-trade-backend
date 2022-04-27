<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyListResponse;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function list()
    {
        return CurrencyListResponse::collection(Currency::all());
    }
}
