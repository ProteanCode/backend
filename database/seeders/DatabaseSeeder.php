<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Protean',
            'email' => 'contact@protean.pl',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $token = $user->createToken('ui')->plainTextToken;

        $this->command->info('Created an user with API token: '.$token);
    }
}
