<?php

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
        Schema::create('buy_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('count');
            $table->decimal('price');
            $table->foreignIdFor(Currency::class)->constrained();
            $table->dateTime('expire_at')->nullable();
            $table->foreignIdFor(ProductionType::class)->nullable()->constrained();
            $table->foreignIdFor(PaymentMethod::class)->constrained();
            $table->text('address');
            $table->foreignIdFor(User::class)->constrained();
            $table->text('comment')->nullable();
            $table->boolean('is_open');
            $table->boolean('is_service');
            $table->boolean('is_auction');
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
        Schema::dropIfExists('buy_requests');
    }
};
