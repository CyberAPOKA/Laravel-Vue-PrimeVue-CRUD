<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Core\Constants\UserStatus;
use App\Core\Constants\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'birthdate' => $faker->date,
                'gender' => $faker->randomElement(['Masculino', 'Feminino', 'Outro']),
                'cpf' => $faker->unique()->numerify('###########'),
                'phone_number' => $faker->unique()->numerify('###########'),
                'city' => $faker->randomElement(['New York', 'Rome', 'London', 'Istanbul', 'Paris']),
                'status' => $faker->randomElement(UserStatus::values()),
                'role' => $faker->randomElement(UserRole::values()),
                // 'is_active' => $faker->boolean,
                'email_verified_at' => $faker->boolean ? now() : null,
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('users')->insert([
            'name' => 'Christian André Steffens',
            'email' => 'oficialsteffens@hotmail.com',
            'password' => Hash::make('123123123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
