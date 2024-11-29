@extends('retro.layouts.app')

@section('main', 'Main Page')

@section('content')
    <div class="container">
        <div class="row col-sm-4">
            @include('retro.layouts.sidebar')
            <!--/.page-side-bar-->
        </div>

        <div class="row col-sm-8">
            <div class=" page-content col-thin-left bordered">
                <h5 class="list-title">
                    <strong>글쓰기</strong>
                </h5>
                <form class="form-horizontal" role="form" method="POST" action="{{ url()->current() }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group
                    {{ $errors->write->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-2 control-label">제목</label>

                        <div class="col-md-9">
                            <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}"
                                   required autofocus>
                            @if ($errors->write->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->write->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->write->has('content') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-2 control-label">내용</label>

                        <div class="col-md-9">

                            <textarea id="content" class="form-control" name="content" required
                                      autofocus>{{ old('content') }}</textarea>
                            @if ($errors->write->has('content'))
                                <span class="help-block">
                                <strong>{{ $errors->write->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer m-3">
                        <button type="submit" class="btn btn-primary"> 저장</button>
                        <a type="button" class="btn btn-default" href="/">취소</a>
                    </div>
                </form>


            </div>
            <!--/.page-content-->
        </div>
    </div>
@endsection