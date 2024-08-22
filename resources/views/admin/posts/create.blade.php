@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Create post
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("admin.posts.store") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="title">Title</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                               name="title" id="title" value="{{ old('title') }}" required>
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="image">Image</label>
                        <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file"
                               name="image" id="image" value="{{ old('image') }}">
                        @if($errors->has('image'))
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </div>
                        @endif
                        <span class="help-block"> </span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="tags">Tags</label>
                        <input class="form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}" type="text"
                               name="tags" id="tags" value="{{ old('tags') }}" required>
                        @if($errors->has('tags'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tags') }}
                            </div>
                        @endif
                        <span class="help-block">Separated by space</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="category_id">Category</label>
                        <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id"
                                id="category_id" required>
                            <option value="0">--- SELECT CATEGORY ---</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if ($category->id == old('category_id')) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('category_id') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="text">text</label>
                        <textarea class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text"
                                  id="text">{{ old('text') }}</textarea>
                        @if($errors->has('post'))
                            <div class="invalid-feedback">
                                {{ $errors->first('text') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
