<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordsControllerTest extends TestCase
{
    use RefreshDatabase;

    function test_renders_change_password_page()
    {
    }

    function test_doesnt_allow_to_change_password_of_a_different_user()
    {
    }

    function test_changes_the_password_if_current_password_matches()
    {
        // assert toast + redirect
    }

    function test_doesnt_change_password_if_current_password_doesnt_match()
    {
    }
}
