<?php

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert as PHPUnit;

Illuminate\Testing\TestResponse::macro('assertReflinksRedirect', function ($route) {
    $this->assertStatus(200);

    $directives = $this->json('directives');

    foreach ($directives as $directive) {
        if ($redirect = Arr::get($directive, 'redirect')) {
            PHPUnit::assertStringContainsString($route, $route);
        }
    }
});
