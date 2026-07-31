@extends('components.layouts.app')

@forelse($posts as $post)
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->ceated_at }}</p>
@empty
    <p>
        No posts yet.
    </p>
@endforelse
