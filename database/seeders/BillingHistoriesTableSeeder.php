<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\BillingHistory;

class BillingHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Creating 10 billing history records
        foreach (range(1, 10) as $index) {
            BillingHistory::create([
                'user_id' => rand(1, 10), // Assuming user exists
                'amount' => $faker->numberBetween(100, 1000),
                'status' => $faker->randomElement(['paid', 'unpaid']),
                'payment_date' => $faker->date,
            ]);
        }
    }
}
