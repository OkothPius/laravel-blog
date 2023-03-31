@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>Edit Post</h1>
        <section class="mt-3">
            <form method="post" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Error message when data is not inputted -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card p-3">
                        <label for="floatingInput">Title</label>
                        <input class="form-control" type="text" name="title" value="{{ $post->title }}">
                        <label for="floatingTextArea">Description</label>
                        <textarea class="form-control" name="description" value="{{ $post->description }}" id="floatingTextarea" cols="30" rows="10">{{ $post->description }}</textarea>
                        <label for="formFile" class="form-label">Add Image</label>
                        <img src="{{ asset('images/'.$post->image) }}" alt="" class="img-post">
                        <input type="hidden" name="hidden_post_image" value="{{$post->image}}">
                        <input class="form-control" type="file" name="image">
                </div>
                <input type="hidden" name="hidden_id" value="{{$post->id}}">
                <button class="btn btn-secondary m-3">Save</button>
            </form>
        </section>
    
    </div>
@endsection