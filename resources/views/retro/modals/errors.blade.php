<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Error!!</h4>
            </div>
            <div class="modal-body">
                <div class="form-group
                    {{ $errors->errors->any() ? ' has-error' : '' }}">
                    <label for="errorMessage" class="col-md-4 control-label">에러 발생!</label>
                    <div class="col-md-12">
                        <input id="errorMessage" type="text" class="form-control" name="errorMessage" disabled>
                        @foreach($errors->errors->all() as $key => $error)
                            <span class="help-block">
                                <strong>{{ $error }}</strong>
                            </span>
                        @endforeach
                    </div>
                </div>

                @if($errors->login->has('errorMessage'))
                    <div class="form-group
                    {{ $errors->login->has('errorMessage') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Error !</label>

                        <div class="col-md-6">
                                <span class="help-block">
                                <strong>{{ $errors->login->first('errorCode')}}</strong>
                                    {{$errors->login->first('errorMessage')}}
                                </span>

                        </div>
                    </div>
                @endif

                <div class="modal-footer m-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>

@if ($errors->errors->any())
    <script>
        $(document).ready(function () {
            $('#errorModal').modal('show');
        });
    </script>
@endif