<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a post owner to update their post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->putJson("/api/posts/{$post->id}", ['title' => 'Updated', 'content' => 'x', 'status' => 'draft'])
        ->assertOk();
});

it('blocks a non-owner from updating a post', function () {
    $owner   = User::factory()->create();
    $other   = User::factory()->create();
    $post    = Post::factory()->create(['user_id' => $owner->id]);

    $this->actingAs($other)
        ->putJson("/api/posts/{$post->id}", ['title' => 'Hack', 'content' => 'x', 'status' => 'draft'])
        ->assertForbidden();
});

it('allows admins to delete any post', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $post  = Post::factory()->create();

    $this->actingAs($admin)
        ->deleteJson("/api/posts/{$post->id}")
        ->assertNoContent();
});
