<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ValidateController extends Controller
{
    public function check(ValidateRequest $request): Response|Application|ResponseFactory
    {
        //Todo: проверить, можно ли убрать $request
        return response([
            "success" => "true"
        ]);
    }
}
