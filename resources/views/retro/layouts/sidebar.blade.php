<div class="page-sidebar bordered">
    <aside>
        <div class="navbar-collapse collapse">
            <div class="inner-box">
                @if(isset($themes) && is_array($themes) && count($themes) > 0)
                    <div class="categories-list  list-filter">
                        <h5 class="list-title"><strong>카테고리</strong></h5>
                        <ul class=" list-unstyled">
                            @foreach($themes as $key => $theme)
                                <li>
                                    <a class="app-genres"
                                       href="/{{request()->segment(1)}}/{{request()->segment(2)}}/theme/{{$theme['titleEn']}}">
                                        {{$theme['title']}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--/.categories-list-->

                    <br>
                @endif

                @if(request()->segment(3) == 'theme' && request()->segment(4) != null)
                    <a class="btn btn-lg btn-primary btn-block" href="{{url()->current()}}/write">글쓰기</a>
                    <br/>
                @endif

                <div style="clear:both"></div>
            </div>
        </div>
        <!--/.categories-list-->
    </aside>
</div>