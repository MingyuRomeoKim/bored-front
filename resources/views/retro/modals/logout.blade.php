
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title-danger" id="myModalLabel">Logout..</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/logout') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-md-12">
                            <span class="alert-danger">
                                <strong>아직 많이 아쉬운데..ㅠ 로그아웃 하시겠습니까??</strong>
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer m-3">
                        <button type="submit" class="btn btn-danger"> 로그아웃</button>
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