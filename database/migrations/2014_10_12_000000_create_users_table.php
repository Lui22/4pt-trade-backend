<?php

use App\Models\UserRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('login');
            $table->string('password');
            $table->string('telephone');
            $table->string('INN');
            $table->string('OGRN');
            $table->string('address');
            $table->string('fullName');
            $table->string('email');
            $table->string('api_token')->nullable();
            $table->foreignIdFor(UserRole::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
