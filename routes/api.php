<?php

use App\Http\Controllers\BuyRequestController;
use App\Http\Controllers\BuyResponseController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductionTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::any('/failedAuth', function () {
    return response([
        "message" => "Failed auth"
    ], 401);
})->name('failedAuth');

Route::post('/validate', [ValidateController::class, 'check']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/userInfo', [UserController::class, 'info']);
    Route::get('/myWonResponses', [UserController::class, 'myWonResponses']);
    Route::get('/myActiveList', [UserController::class, 'buyerRequestsActiveList']);
    Route::get('/chats', [MessageController::class, 'getChats']);

    Route::get('/suppliers', [UserController::class, 'suppliersList']);
    Route::get('/purchasers', [UserController::class, 'purchasersList']);

    Route::get('/currencies', [CurrencyController::class, 'list']);
    Route::get('/paymentMethods', [PaymentMethodController::class, 'list']);

    Route::resource('productionType', ProductionTypeController::class);

        Route::get('/request/filter', [BuyRequestController::class, 'filter']);
    Route::resource('request', BuyRequestController::class);
        Route::get('/request/{request}/close', [BuyRequestController::class, 'close']);
        Route::get('/request/{request}/open', [BuyRequestController::class, 'open']);

    Route::resource('response', BuyResponseController::class);
        Route::post('/response/{buyResponse}/status', [BuyResponseController::class, 'changeStatus']);

    Route::get('/chat/{response}', [MessageController::class, 'index']);
    Route::post('/chat/{response}', [MessageController::class, 'store']);

    Route::get('/usersRequestsList', [UserController::class, 'usersRequestsList']);
});
