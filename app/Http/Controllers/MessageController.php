<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Http\Resources\ConversationResponse;
use App\Http\Resources\UserResponse;
use App\Models\BuyResponse;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array|string
     */
    public function index(Request $request, BuyResponse $response)
    {
        $user = null;

        //Поставщик
        if (Auth::user()->role->id == 1) {
            $user = $response->buy_request->user;
        } //Закупщик
        else {
            $user = $response->user;
        }

        return
            response([
                "to" => UserResponse::make($user),
                "conversation" => Message::where('buy_response_id', $response->id)->get()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, BuyResponse $response)
    {
        $message = Message::create([
            "user_id" => Auth::id(),
            "buy_response_id" => $response->id,
            "message" => $request->message,
        ]);

        $user = (Auth::user()->role->id == 2 ? $response->user : $response->buy_request->user);

        broadcast(new NewMessageEvent($message, $user));

        return Message::where('buy_response_id', $response->id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     * @return Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Message $message
     * @return Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return Response
     */
    public function destroy(Message $message)
    {
        //
    }

    public function getChats()
    {
        if (Auth::user()->role->id != 2) {
            return response([
                "message" => "Ты не Закупщик"
            ]);
        }

        return
            ConversationResponse::collection(
                BuyResponse::whereHas('buy_request', function ($query) {
                    $query->where('user_id', Auth::id());
                })->get()
            );
    }
}
