<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
use Faker\Factory as Faker;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Creating 10 invoices
        foreach (range(1, 10) as $index) {
            Invoice::create([
                'guarantor_id' => rand(1, 10), // Assuming guarantor exists
                'amount' => $faker->numberBetween(100, 1000),
                'status' => $faker->randomElement(['paid', 'unpaid']),
                'invoice_date' => $faker->date,
            ]);
        }
    }
}
