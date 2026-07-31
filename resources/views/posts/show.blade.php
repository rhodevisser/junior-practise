@extends('components.layouts.app')

<h1>{{ $post->title }}</h1>
<p>
    @datetime($post->created_at)
</p>

