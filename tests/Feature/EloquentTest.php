<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('only returns published posts via scope', function () {
Post::factory()->create(['status' => 'published']);
Post::factory()->create(['status' => 'draft']);

expect(Post::published()->count())->toBe(1);
});

it('eager loads user without N+1', function () {
User::factory()->has(Post::factory()->count(3))->create();

$queryCount = 0;
DB::listen(fn () => $queryCount++);

Post::with('user')->get();

expect($queryCount)->toBeLessThanOrEqual(2);
});

it('creates a post with mass assignment', function () {
$user = User::factory()->create();

$post = Post::create([
'title'   => 'Hello',
'content' => 'World',
'status'  => 'draft',
'user_id' => $user->id,
]);

expect($post->title)->toBe('Hello');
});

it('attaches tags to posts via many-to-many', function () {
$post = Post::factory()->create();
$tags = Tag::factory()->count(3)->create();

$post->tags()->attach($tags->pluck('id'));

expect($post->tags()->count())->toBe(3);
});
