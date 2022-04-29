<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationResponse;
use App\Http\Resources\UserResponse;
use App\Models\BuyResponse;
use App\Models\Message;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|ResponseFactory|Response
     */
    public function index(Request $request, BuyResponse $response): Response|Application|ResponseFactory
    {
        $user = null;
        //Todo: проверить, можно ли убрать $user, $request

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
    public function store(Request $request, BuyResponse $response): Response
    {
        $message = Message::create([
            "user_id" => Auth::id(),
            "buy_response_id" => $response->id,
            "message" => $request->message,
        ]);

        $user = (Auth::user()->role->id == 2 ? $response->user : $response->buy_request->user);

//        broadcast(new NewMessageEvent($message, $user));
//Todo: прикрутить RabbitMQ
        return Message::where('buy_response_id', $response->id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Message $message
     * @return void
     */
    public function show(Message $message): void
    {
        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Message $message
     * @return void
     */
    public function update(Request $request, Message $message): void
    {
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Message $message
     * @return void
     */
    public function destroy(Message $message): void
    {
        return;
    }

    public function getChats(): Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|Application|ResponseFactory
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
