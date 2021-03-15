<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfilesControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_the_profile_edit_page()
    {
        // Given we're authenticated
        $this->actingAs(User::factory()->create());

        // When we visit the profile page
        $response = $this->get(route('auth.profiles.edit', Auth::id()));

        // Then we should successfuly see the form
        $response->assertOk();
    }

    function test_doesnt_allow_other_users_to_visit_profile()
    {
        // Given we're authenticated as user 1
        $this->actingAs(User::factory()->create());

        // When we visit the profile page of user 2
        $response = $this->get(route('auth.profiles.edit', User::factory()->create()->id));

        // Then we should be denied
        $response->assertForbidden();
    }

    function test_updates_name_and_avatar()
    {
        $this->withoutExceptionHandling();

        // Given we're authenticated
        $user = User::factory()->create();
        $this->actingAs($user);

        // When we submit the update profile form
        $response = $this->putJson(route('auth.profiles.update', $user->id), [
            'name' => 'Updated name',
            'avatar' => UploadedFile::fake()->image('picture.png')
        ]);

        // Then our profile should reflect the updated values
        // $this->assertEquals('Updated name', $user->fresh()->name);
        $this->assertTrue($user->fresh()->avatar->attached());

        // ... and we should be redirected back
        $response->assertReflinksRedirect(route('auth.profiles.edit', $user->id));
    }

    function test_toggles_two_factor_authentication()
    {
        // Given we're authenticated
        // When we submit the form to enable two factor authentication
        // Then two factor authentication should be enabled
        // When we submit the form to disable two factor authentication
        // Then two factor authentication should be disable
    }
}
