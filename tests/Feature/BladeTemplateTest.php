<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the post index with posts', function () {
    Post::factory()->count(3)->create();

    $this->get('/posts')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHas('posts');
});

it('shows the empty message when there are no posts', function () {
    $this->get('/posts')
        ->assertOk()
        ->assertSee('No posts yet.');
});

it('renders a single post', function () {
    $post = Post::factory()->create(['title' => 'Hello World']);

    $this->get("/posts/{$post->id}")
        ->assertOk()
        ->assertSee('Hello World');
});
