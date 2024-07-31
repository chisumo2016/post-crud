@extends('layouts.master')

@section('content')
    <div class="row mt-3">
        @foreach($posts as $post)
            <x-post.index :post="$post"/>
        @endforeach
    </div>
@endsection
