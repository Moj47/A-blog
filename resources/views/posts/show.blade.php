@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $post->title }}</div>

                    <div class="card-body">
                        <div class="">
                            @if($post->image)
                            <img width="20%" src="storage/{{ $post->image }}" alt="Post Image">

                            @else
                            <h1>No image for this post</h1>
                            @endif
                        </div>

                        <div class="my-5">{!! nl2br($post->text) !!}</div>

                        @foreach ($post->tags as $tag)
                            <a href="#" class="btn btn-outline-secondary">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
