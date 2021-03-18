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


Illuminate\Testing\TestResponse::macro('assertReflinksToast', function ($type) {
    $this->assertStatus(200);

    $directives = $this->json('directives');

    foreach ($directives as $directive) {
        if (Arr::get($directive, 'action') == 'append') {
            if ($directive['target'] == 'toast-container') {
                PHPUnit::assertStringContainsString('data-toast-' . $type, $directive['html']);
                return;
            }
        }
    }

    PHPUnit::fail('Expected response to contain a toast. It did not.');
});
