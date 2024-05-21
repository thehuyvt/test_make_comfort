<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 1,
            'phone_number' => '0123456789',
        ]);

        Customer::create([
            'name' => 'Huy',
            'email' => 'huy@gmail.com',
            'password' => Hash::make('123456'),
            'address' => 'Ha Noi',
            'gender' => 1,
            'status' => 1,
            'phone_number' => '0123456789',
        ]);
    }
}
