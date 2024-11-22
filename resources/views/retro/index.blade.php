@extends('retro/layouts/app')

@section('title', 'Main Page')

@section('content')
    <div class="container">
        <div class="row col-sm-12">
            @include('retro.layouts.posts')
        </div>
    </div>
@endsection