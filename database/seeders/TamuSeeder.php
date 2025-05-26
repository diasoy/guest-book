<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tamu;
use Carbon\Carbon;
use Faker\Factory as Faker;

class TamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');


        for ($i = 0; $i < 100; $i++) {
            $year = rand(2020, 2025);
            $month = rand(1, 12);
            $day = rand(1, 28);

            $date = Carbon::create($year, $month, $day, rand(8, 17), rand(0, 59), 0);

            if ($date->isFuture()) {
                $date = Carbon::now()->subDays(rand(0, 30));
            }

            Tamu::create([
                'nama' => $faker->name,
                'email' => $faker->email,
                'instansi' => $faker->company,
                'telepon' => $faker->phoneNumber,
                'keperluan' => $faker->text(200),
                'created_at' => $date,
                'updated_at' => $date,
                'image_url' => null,
            ]);
        }
    }
}
