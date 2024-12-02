<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">SignUp</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" method="POST" action="{{ url('signUp') }}">
                    {{ csrf_field() }}

                    <div class="form-group
                    {{ $errors->signUp->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                   required autofocus>
                            @if ($errors->signUp->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->signUp->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autofocus>
                            @if ($errors->signUp->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->signUp->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password"
                                   value="{{old('password')}}" required>
                            @if ($errors->signUp->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->signUp->has('passwordCheck') ? ' has-error' : '' }}">
                        <label for="passwordCheck" class="col-md-4 control-label">Password Check</label>

                        <div class="col-md-6">
                            <input id="passwordCheck" type="password" class="form-control" name="passwordCheck"
                                   value="{{old('passwordCheck')}}" required>
                            @if ($errors->signUp->has('passwordCheck'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('passwordCheck') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->signUp->has('region') ? ' has-error' : '' }}">
                        <label for="regionId" class="col-md-4 control-label">지역 설정</label>

                        <div class="col-md-6">
                            <select id="regionId" class="form-control" name="regionId" required>
                                @foreach($regions as $region)
                                    <option value="{{$region['id']}}"
                                            {{ old('regionId') == $region['id'] ? 'selected' : '' }}>
                                        {{$region['title']}}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->signUp->has('regionId'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('regionId') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->signUp->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Phone Number</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control" name="phone" value="{{old('phone')}}"
                                   required>
                            @if ($errors->signUp->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group
                    {{ $errors->signUp->has('address') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">Address</label>

                        <div class="col-md-6">
                            <input id="address" type="text" class="form-control" name="address"
                                   value="{{old('address')}}" required>
                            @if ($errors->signUp->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->signUp->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 개인정보 제공 동의 -->
                    <div class="form-group
                    {{ $errors->signUp->has('agree') ? ' has-error' : '' }}">
                        <label for="agree" class="col-md-4 control-label">(필수)개인정보 수집/이용 동의</label>

                        <div class="col-md-1">
                            <input id="agree" type="checkbox" class="form-control" name="agree"
                                   value="1" {{ old('agree') ? 'checked' : '' }} required>
                            @if ($errors->signUp->has('agree'))
                                <span class="help-block
                                {{ $errors->signUp->has('agree') ? ' has-error' : '' }}">
                                <strong>{{ $errors->signUp->first('agree') }}</strong>
                                </span>
                            @endif
                        </div>

                        <label for="adAgree" class="col-md-4 control-label">(선택) 광고성 정보 수신 동의</label>

                        <div class="col-md-1">
                            <input id="adAgree" type="checkbox" class="form-control" name="adAgree"
                                   value="{{old('adAgree')}}">
                            @if ($errors->signUp->has('adAgree'))
                                <span class="help-block
                                {{ $errors->signUp->has('adAgree') ? ' has-error' : '' }}">
                                <strong>{{ $errors->signUp->first('adAgree') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="modal-footer m-3">
                        <button type="submit" class="btn btn-primary"> SignUp</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@if ($errors->signUp->any())
    <script>
        $(document).ready(function () {
            $('#signUpModal').modal('show');
        });
    </script>
@endif
