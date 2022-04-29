<?php

namespace Database\Seeders;

use App\Models\BuyResponseStatus;
use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        UserRole::factory()->count(2)->state(
            new Sequence(
                ['name' => 'Поставщик'],
                ['name' => 'Закупщик'],
            )
        )->create();

        Currency::factory()->count(4)->state(
            new Sequence(
                [
                    'name' => 'Рубли',
                    'character' => '₽',
                    'rubs' => 1,
                ],
                [
                    'name' => 'Китайские Юани',
                    'character' => '¥',
                    'rubs' => 13.00,
                ],
                [
                    'name' => 'Доллары США',
                    'character' => '$',
                    'rubs' => 82.85,
                ],
                [
                    'name' => 'Евро',
                    'character' => '€',
                    'rubs' => 89.58,
                ],
            )
        )->create();

        PaymentMethod::factory()->count(3)->state(
            new Sequence(
                ["name" => "C авансом"],
                ["name" => "Поэтапная"],
                ["name" => "Единовременная"],
            )
        )->create();

        BuyResponseStatus::factory()->count(3)->state(
            new Sequence(
                ["name" => "Отклонено закупщиком"],
                ["name" => "Одобрено закупщиком"],
                ["name" => "На рассмотрении"],
            )
        )->create();
    }
}
