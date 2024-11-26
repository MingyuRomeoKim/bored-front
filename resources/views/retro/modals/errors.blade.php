<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Error!!</h4>
            </div>
            <div class="modal-body">
                @if($errors->errors->has('code'))
                    <div class="form-group
                    {{ $errors->errors->has('code') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">에러 코드</label>
                        <div class="col-md-6">
                            <span class="help-block">
                                <strong>{{ $errors->errors->first('code') }}</strong>
                            </span>

                        </div>
                    </div>
                @endif

                @if($errors->errors->has('message'))
                    <div class="form-group
                    {{ $errors->errors->has('message') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">에러 메세지</label>

                        <div class="col-md-6">
                            <span class="help-block">
                                <strong>{{ $errors->errors->first('message')}}</strong>
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