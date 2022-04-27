<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateRequest;

class ValidateController extends Controller
{
    public function check(ValidateRequest $request)
    {
        return response([
            "success" => "true"
        ]);
    }
}
