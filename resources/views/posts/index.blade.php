@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="titlebar">
            <a class="btn btn-secondary float-end mt-3" href="{{ route('posts.create') }}" role="button">Add Post</a>
            <h1>Mini post list</h1>
        </div>
    
    <hr>
    <!-- Message if a post is posted successfully -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div class="row">
                <div class="col-12">
                   <div class="row">
                        <div class="col-2">
                            <img class="img-fluid" style="max-width:50%;" src="{{ asset('images/'.$post->image)}}" alt="">
                        </div>
                        <div class="col-10">
                            <h4>{{$post->title}}</h4>
                        </div>
                    </div>
                    <p>{{$post->description}}</p>
                    <!-- Update and Delete buttons -->
                    <div style="display: flex">
                        <a class="btn btn-success mx-3" href="{{ route('posts.edit', $post->id) }}" role="button">
                            Update
                        </a>

                        <form method="post" action="{{ route('posts.destroy', $post->id) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger" onclick="deleteConfirm(event)">
                                Delete
                            </button>
                        </form>
                    </div>  
                    <hr>
                </div>
            </div>
        @endforeach
    @else
        <p>No Posts found</p>
    @endif
    </div>
    <!-- Using the sweet alert notification system -->
    <script>
        window.deleteConfirm = function(e) {
            e.preventDefault();
            var form = e.target.form;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
            })
        }
    </script>
@endsection