<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SessionsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_sign_in_page()
    {
        // When we visit the sign in page
        $response = $this->get(route('auth.sessions.create'));

        // Then we should successfuly see the form
        $response->assertStatus(200);
    }

    function test_signs_in_and_redirects_to_workspaces_if_user_doesnt_have_2fa_enabled()
    {
        // Given we have a user record that doesn't have 2fa enabled.
        $user = User::factory()->create();

        // When we submit the sign in form with the user's credentials
        $response = $this->postJson(route('auth.sessions.store'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // Then we should be authenticated
        $this->assertEquals($user->id, Auth::id());

        // ... and we should be redirected to /workspaces
        $response->assertReflinksRedirect(route('workspaces.index'));
    }

    function test_signs_in_and_redirects_to_confirmation_if_user_has_2fa_enabled()
    {
        // Given we have a user record in the database that has 2fa enabled.
        $user = User::factory()->withTwoFactorAuthentication()->create();

        // When we submit the sign in form with the user's credentials
        $response = $this->postJson(route('auth.sessions.store'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // Then we should be authenticated
        $this->assertFalse(Auth::check());

        // ... and we should be redirected to /workspaces
        $response->assertReflinksRedirect(route('auth.session_confirmations.create'));
    }

    function test_doesnt_sign_in_with_incorrect_email_or_password()
    {
        // When we submit the sign in form with incorrect credentials
        $response = $this->postJson(route('auth.sessions.store'), [
            'email' => 'incorrect@example.org',
            'password' => 'password'
        ]);

        // Then we should see validation error
        $response->assertJsonValidationErrors(['email']);
    }

    function test_signs_out()
    {
        // Given we're authenticated
        $user = User::factory()->create();
        $this->actingAs($user);

        // When we sign out
        $response = $this->deleteJson(route('auth.sessions.destroy', 'self'));

        // Then the session should be deleted
        $this->assertFalse(Auth::check());

        // ... and we should be redirected to sign in
        $response->assertReflinksRedirect(route('auth.sessions.create'));
    }
}
