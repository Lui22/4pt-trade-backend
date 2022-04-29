<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodController extends Controller
{
    public function list(): Collection
    {
        return PaymentMethod::all('id', 'name');
    }
}
