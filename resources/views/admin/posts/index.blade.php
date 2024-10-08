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
      <img src="{{URL::asset('storage/'.$post->image)}}" alt="profile Pic" height="200" width="200">
      @else
      <p>No image</p>
  @endif
  <br>
  <a href="{{route('admin.posts.edit',$post->id)}}">Edit</a>
  <br>
  <a href="{{route('admin.posts.delete',$post->id)}}">delete</a>
  </div>
  <br>
  <br>
  <br>
  <br>
  @endforeach
  @endif
@endsection
