<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Luiz Paulo',
            'email' => 'luiz.pv9@gmail.com',
            'two_factor_authentication' => 'disabled',
            'password' => Hash::make('1234')
        ]);
    }
}
