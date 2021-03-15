<?php

namespace Tests\Feature\Auth;

use App\Models\Session;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignInByEmailOnlyControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_sign_in_by_email_page()
    {
        // When we visit the sign in by email page
        $response = $this->get(route('auth.sign_in_by_email_only.create'));

        // Then we should successfuly see the form.
        $response->assertOk();
    }

    function test_creates_a_pending_session()
    {
        // Given we have a user with 2fa disabled
        $user = User::factory()->create();

        // When we submit sign in by email only
        $response = $this->postJson(route('auth.sign_in_by_email_only.store'), [
            'email' => $user->email
        ]);

        // Then a new session should be created in pending state
        $session = Session::latest()->first();
        $this->assertFalse($session->isActive());

        // ... and we should be redirected to confirmations
        $response->assertReflinksRedirect(route('auth.session_confirmations.create'));
    }

    function test_redirects_to_confirmation_even_if_email_is_not_found()
    {
        // When we submit sign in by email only with an email that doesn't exist
        $response = $this->postJson(route('auth.sign_in_by_email_only.store'), [
            'email' => 'wrong@example.org'
        ]);

        // Then we should be redirected to confirmations to pretend everything worked
        $response->assertReflinksRedirect(route('auth.session_confirmations.create'));
    }
}
