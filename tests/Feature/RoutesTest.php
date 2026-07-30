<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('resolves the public post index route', function () {
    $this->getJson('/posts')->assertOk();
});

it('returns 404 for a non-existent post', function () {
    $this->getJson('/posts/99999')->assertNotFound();
});

it('blocks unauthenticated users from creating posts', function () {
    $this->postJson('/posts', [])->assertUnauthorized();
});

