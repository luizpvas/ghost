<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_change_password_page()
    {
        // Given we're signed in
        $this->signIn();

        // When we visit the edit password page
        $response = $this->get(route('auth.passwords.edit', $this->user));

        // Then we should see the form
        $response->assertOk();
    }

    function test_doesnt_allow_to_change_password_of_a_different_user()
    {
        // Given we're signed in as user 1
        $this->signIn();

        // When we try to visit the edit password page of user 2
        $otherUser = User::factory()->create();
        $response = $this->get(route('auth.passwords.edit', $otherUser));

        // Then we should be denied
        $response->assertForbidden();
    }

    function test_changes_the_password_if_current_password_matches()
    {
        // Given we're signed in
        $this->signIn();

        // When we submit the change password form
        $response = $this->putJson(route('auth.passwords.update', $this->user), [
            'current_password' => 'password',
            'new_password' => 'abcd1234'
        ]);

        // Then our password should be updated
        $this->assertNotEquals($this->user->password, $this->user->fresh()->password);

        // ... and we should be redirected back to profile
        $response->assertReflinksRedirect(route('auth.profiles.edit', $this->user));

        // ... and we should see a success toast
        $response->assertReflinksToast('success');
    }

    function test_doesnt_change_password_if_current_password_doesnt_match()
    {
        // Given we're signed in
        $this->signIn();

        // When we submit the change password form with an incorrect current password
        $response = $this->putJson(route('auth.passwords.update', $this->user), [
            'current_password' => 'wrong-password',
            'new_password' => 'abcd1234'
        ]);

        // Then we should see a validation error
        $response->assertJsonValidationErrors(['current_password']);
    }
}
