<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('TRUNCATE TABLE users');

        User::create([
            'name' => 'Protean',
            'email' => 'contact@protean.pl',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
