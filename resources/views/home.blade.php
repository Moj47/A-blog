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
        <p>{{ $post->text }}</p>
        @if($post->image)
        <img width="20%" height="50%" src="storage/{{ $post->image }}" alt="Post Image">
    @else
        <p>No image</p>
    @endif
        <a href="{{route('post.show',$post->id)}}">Read more</a>
    </div>
    <br>
    <br>
    <br>
    <br>
    @endforeach
  @endif
@endsection
