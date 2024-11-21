@extends('retro/layouts/app')

@section('title', 'Main Page')

@section('content')
    <div class="container">
        <div class="row col-sm-12">
            <div class=" page-content col-thin-left bordered">
                <div class="category-list">
                    전체 게시글
                </div>
            </div>

            @include('retro.layouts.posts')
        </div>
    </div>
@endsection