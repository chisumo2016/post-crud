@extends('layouts.master')

@section('content')
    <div class="row mt-3">
        @foreach($posts as $post)
            <x-post.index>
                <x-slot name="title">
                    {{ $post->title}}
                </x-slot>

                <x-slot name="description">
                    {{ $post->description}}
                </x-slot>
            </x-post.index>
        @endforeach
    </div>

{{--    <x-button>Submit</x-button>--}}
@endsection
