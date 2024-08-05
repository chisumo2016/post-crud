@extends('layouts.master')

@section('content')
    <div class="">
        <div class="display-3">{{__('frontends.Welcome to our application!')  }}</div>
        <p>{{__('frontends.Localization in Laravel allows you to define translations for various language strings in your applications
            These translations can be used in your application\'s views , as well as within your applications PHP code ') }}
        </p>

        <div class="row">
            <ul class="row">
                <li>{{__('frontends.Home')}}</li>
                <li>{{__('frontends.About')}}</li>
                <li>{{__('frontends.Contact')}}</li>
                <li>{{__('frontends.More') }}</li>
            </ul>
        </div>
    </div>
@endsection
