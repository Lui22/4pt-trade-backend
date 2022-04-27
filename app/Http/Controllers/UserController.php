<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\BuyRequestResponse;
use App\Http\Resources\BuyResponseResponse;
use App\Http\Resources\UserResponse;
use App\Models\BuyRequest;
use App\Models\BuyResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->only(
            'firstname',
            'lastname',
            'middlename',
            'login',
            'telephone',
            'INN',
            'OGRN',
            'address',
            'fullName',
            'email',
            'user_role_id'
        );

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->generateToken();

        Auth::setUser($user);

        return response([
            "api_token" => Auth::user()->api_token
        ], 201);
    }

    public function login(ApiRequest $request)
    {
        if (!Auth::attempt($request->only('login', 'password'))) {
            return response([
                "message" => "Failed auth"
            ], 401);
        }

        Auth::user()->generateToken();

        return response([
            "api_token" => Auth::user()->api_token
        ]);
    }

    public function usersRequestsList()
    {
        //Поставщик
        if (Auth::user()->role->id == 1) {
            $list = BuyResponse::where('user_id', Auth::id())->get();
            return BuyResponseResponse::collection($list);
        } //Закупщик
        else {
            $list = BuyRequest::where('user_id', Auth::id())->get();
            return BuyRequestResponse::collection($list);
        }
    }

    public function buyerRequestsActiveList()
    {
        if (Auth::user()->role->id != 2) {
            return response([
                "message" => "Ты не Закупщик"
            ]);
        }

        $list = BuyRequest::where([
            'user_id' => Auth::id(),
            'is_open' => true])
                ->get();
        return BuyRequestResponse::collection($list);
    }

    public function suppliersList()
    {
        return UserResponse::collection(User::where('user_role_id', 1)->get());
    }

    public function purchasersList()
    {
        return UserResponse::collection(User::where('user_role_id', 2)->get());
    }

    public function info()
    {
        return UserResponse::make(Auth::user());
    }

    public function myWonResponses()
    {
        if (Auth::user()->role->id != 1) {
            return response([
                "message" => "Ты не поставщик"
            ]);
        }

        return BuyResponseResponse::collection(BuyResponse::where([
            "user_id" => Auth::id(),
            "buy_response_status_id" => 2
        ])->get());
    }
}
