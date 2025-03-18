<?php

namespace Database\Seeders;

use App\Models\Guarantor;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuarantorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Creating 10 guarantors
        foreach (range(1, 10) as $index) {
            Guarantor::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
            ]);
        }
    }
}
