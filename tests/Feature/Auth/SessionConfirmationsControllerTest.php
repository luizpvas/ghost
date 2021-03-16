<?php

namespace Tests\Feature\Auth;

use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SessionConfirmationsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_the_confirmation_page()
    {
        // Given we have a pendign session
        $session = Session::factory()->pending()->create();

        // When we visit the confirmation page
        $signedUrl = URL::signedRoute('auth.session_confirmations.create', ['session_id' => $session->id]);
        $response = $this->get($signedUrl);

        // Then we should successfully see the form
        $response->assertOk();
    }

    function test_activates_the_session_if_confirmation_code_is_correct()
    {
        // Given we have a pending session
        $session = Session::factory()->pending()->create();

        // When we submit the confirmation form with correct code
        $response = $this->postJson(route('auth.session_confirmations.store'), [
            'session_id' => $session->id,
            'confirmation_code' => $session->confirmation_code
        ]);

        // Then we should be signed in
        $this->assertEquals($session->user->id, Auth::id());

        // ... and we should be redirected to /workspaces
        $response->assertReflinksRedirect(route('workspaces.index'));
    }

    function test_doesnt_activate_the_session_if_confirmation_code_is_incorrect()
    {
        // Given we have a pending session
        $session = Session::factory()->pending()->create();

        // When we submit the confirmation form with correct code
        $response = $this->postJson(route('auth.session_confirmations.store'), [
            'session_id' => $session->id,
            'confirmation_code' => 'wrong-code'
        ]);

        // Then we should see a validation error
        $response->assertJsonValidationErrors(['confirmation_code']);
    }

    function test_doesnt_render_confirmation_form_if_session_is_already_active()
    {
        // Given we have an active session
        $session = Session::factory()->create();

        // When we try to visit the confirmation form
        $signedUrl = URL::signedRoute('auth.session_confirmations.create', ['session_id' => $session->id]);
        $response = $this->get($signedUrl);

        // Then we should see a static page that displays 'session already active'
        $response->assertOk()->assertSee('Session is already active');
    }
}
