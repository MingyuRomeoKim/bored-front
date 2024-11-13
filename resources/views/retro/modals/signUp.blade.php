<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">SignUp</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/signUp') }}">
                    {{ csrf_field() }}

                    <div class="form-group
                    {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                   required autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block
                                <strong">{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block
                                <strong">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block
                                <strong">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->has('passwordCheck') ? ' has-error' : '' }}">
                        <label for="passwordCheck" class="col-md-4 control-label">Password Check</label>

                        <div class="col-md-6">
                            <input id="passwordCheck" type="password" class="form-control" name="passwordCheck" required>
                            @if ($errors->has('passwordCheck'))
                                <span class="help-block
                                <strong">{{ $errors->first('passwordCheck') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Phone Number</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control" name="phone" required>
                            @if ($errors->has('phone'))
                                <span class="help-block
                                <strong">{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Address</label>

                        <div class="col-md-6">
                            <input id="address" type="text" class="form-control" name="address" required>
                            @if ($errors->has('address'))
                                <span class="help-block
                                <strong">{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer m-3">
                        <button type="submit" class="btn btn-primary" > SignUp</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>