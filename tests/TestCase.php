<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Signed in user.
     * 
     * @var User
     */
    protected $user;

    /**
     * Creates a new user from the factory and authenticates as that user.
     * 
     * @return $this
     */
    function signIn()
    {
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        return $this;
    }
}
