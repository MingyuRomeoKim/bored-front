<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group
                    {{ $errors->login->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autofocus>
                            @if ($errors->login->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->login->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->login->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->login->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->login->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($errors->login->has('errorMessage'))
                    <div class="form-group
                    {{ $errors->login->has('errorMessage') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">알수없는오류</label>

                        <div class="col-md-6">
                                <span class="help-block">
                                <strong>{{ $errors->login->first('errorCode')}}</strong>
                                    {{$errors->login->first('errorMessage')}}
                                </span>

                        </div>
                    </div>
                    @endif

                    <div class="modal-footer m-3">
                        <button type="submit" class="btn btn-primary"> Login</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@if ($errors->login->any())
    <script>
        $(document).ready(function () {
            $('#loginModal').modal('show');
        });
    </script>
@endif