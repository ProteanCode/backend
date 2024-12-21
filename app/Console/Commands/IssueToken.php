<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class IssueToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'issue-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issues the user token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->warn('No users found, did you run php artisan db:seed?');
        }

        /** @var User $user */
        foreach ($users as $user) {
            $newToken = $user->createToken(time());
            $this->info($newToken->plainTextToken);
        }
    }
}
