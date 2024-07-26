@extends('layouts.master')

@section('content')
    <div class="main-content mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>All Posts</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('posts.create') }}" class="btn btn-success mx-1">Create post</a>
                        <a href="{{ route('posts.trashed') }}" class="btn btn-warning mx-1">Trashed</a>
                    </div>
                    </div>

            </div>
            <div class="card-body">
                <table class="table table-striped   table-bordered  border-dark">
                    <thead style="background: #f2f2f2">
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 10%;">Title</th>
                        <th scope="col" style="width: 10%;">Image</th>
                        <th scope="col" style="width:  30%;">Description</th>
                        <th scope="col" style="width: 10%;">Category</th>
                        <th scope="col" style="width: 10%;">Publish Date</th>
                        <th scope="col" style="width: 10%;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <th scope="row">{{ $post->id }}</th>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <img src="{{ asset($post->image) }}" alt="" width="80">
                                </td>
                                <td>{{ $post->description  }}</td>
                                <td>{{ $post->category->name  }}</td>
                                <td>{{ $post->created_at->format('F j, Y')  }}</td>
                                <td>
                                    <a href="{{ route('posts.show', $post->id)  }}" class="btn btn-success btn-sm">Show</a>

                                    <a href="{{ route('posts.edit', $post->id)  }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                          <button class="btn-sm btn-danger btn">Delete</button>
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
