<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a post with valid data', function () {
   $this->actingAs(User::factory()->create())
        ->postJson('/api/posts', [
            'title'   => 'My First Post',
            'content' => 'Some content here.',
            'status'  => 'draft',
        ])
        ->assertCreated()
        ->assertJsonFragment(['title' => 'My First Post']);
});

it('rejects a post with missing title', function () {
    $this->actingAs(User::factory()->create())
        ->postJson('/api/posts', ['content' => 'Content.', 'status' => 'draft'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title']);
});

it('deletes a post', function () {
    $this->actingAs(User::factory()->create());
    $post = Post::factory()->create();
    $this->deleteJson("/api/posts/{$post->id}")->assertNoContent();
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('does not delete a post for non authenticated user', function () {
    $post = Post::factory()->create();
    $this->deleteJson("/api/posts/{$post->id}")
        ->assertStatus(401);;
});


