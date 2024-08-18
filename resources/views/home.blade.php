<!-- Extend the default layout -->
@extends('layouts.app')

<!-- Define the content section -->
@section('content')
  <!-- Display a message if there are no posts -->
  @if(count($posts) == 0)
    <p>No posts found</p>
  @else
    <!-- Loop through each post and display it -->
    @foreach($posts as $post)
      <div class="post">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->description }}</p>
        <img src="{{ $post->image }}" alt="Post Image">
        <a href="{{route('post.show',$post->id)}}">Read more</a>
    </div>
    @endforeach
  @endif
@endsection
