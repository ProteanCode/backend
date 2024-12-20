<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    protected function getUser(): User
    {
        if ($this->user) {
            return $this->user;
        }

        $this->user = User::query()->where('email', 'contact@protean.pl')->firstOrFail();

        return $this->user;
    }
}
