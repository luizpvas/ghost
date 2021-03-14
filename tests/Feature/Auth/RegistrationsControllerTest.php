<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegistrationsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_registration_page()
    {
        // When we visit the registrations page
        $response = $this->get(route('auth.registrations.create'));

        // Then we should get a successful response
        $response->assertStatus(200);
    }

    function test_registers_a_new_user()
    {
        // Given we submit the registration form with valid data
        $response = $this->post(route('auth.registrations.store'), [
            'name' => 'Luiz Paulo',
            'email' => 'luiz.pv9@gmail.com',
            'password' => 'magicisfake'
        ]);

        // Then we should be authenticated by session
        $this->assertTrue(Auth::check());

        // ... and we should be redirected to /workspaces page
        $response->assertReflinksRedirect(route('workspaces.index'));
    }

    function test_validates_email_is_unique()
    {
        // Given there is already a user in the database with the email
        $email = 'luiz.pv9@gmail.com';
        User::factory()->create(['email' => $email]);

        // When we submit the registration form with that email
        $response = $this->postJson(route('auth.registrations.store'), [
            'name' => 'Luiz Paulo',
            'email' => $email,
            'password' => 'magicisfake'
        ]);

        // Then we should see a validation error
        $response->assertJsonValidationErrors(['email']);
    }

    function test_validates_password_is_weak()
    {
        // When we submit the registration with a weak password
        $response = $this->postJson(route('auth.registrations.store'), [
            'name' => 'Luiz Paulo',
            'email' => 'luiz.pv9@gmail.com',
            'password' => 'abcd'
        ]);

        // Then we should see a validation error
        $response->assertJsonValidationErrors(['password']);
    }
}
