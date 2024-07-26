@extends('layouts.master')

@section('content')
    <div class="main-content mt-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Edit Posts</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('posts.index') }}" class="btn btn-success mx-1">Back</a>

                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" value="{{ $post->title }}">
                    </div>
                    <div class="form-group">
                        <div class="mt-2">
                            <img src="{{asset($post->image) }}" alt="{{ $post->image }}" style="width: 100px">
                        </div>
                        <label for="" class="form-label">Image</label>
                        <input type="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Description</label>
                        <textarea name="" id="" cols="30" rows="10" class="form-control">{{ $post->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Category</label>
                        <select name="" id="" class="form-control">
                            <option value="">Select </option>
                            @foreach($categories as $category)
                                <option {{ $category->id == $post->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn  btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
