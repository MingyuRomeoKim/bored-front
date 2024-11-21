@extends('retro.layouts.app')

@section('title', 'Main Page')

@section('content')
    <div class="container">
        <div class="row col-sm-4">
            @include('retro.layouts.sidebar')
            <!--/.page-side-bar-->
        </div>

        <div class="row col-sm-8">
            @include('retro.layouts.posts')
        </div>
    </div>
@endsection