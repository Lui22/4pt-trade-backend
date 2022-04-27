<?php

use App\Models\BuyRequest;
use App\Models\BuyResponseStatus;
use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\ProductionType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(BuyRequest::class)->constrained();
            $table->dateTime('supply_at')->nullable();
            $table->foreignIdFor(ProductionType::class)->constrained();
            $table->decimal('price');
            $table->foreignIdFor(Currency::class)->constrained();
            $table->foreignIdFor(PaymentMethod::class)->constrained();
            $table->text('address');
            $table->foreignIdFor(BuyResponseStatus::class)->constrained();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_responses');
    }
};
