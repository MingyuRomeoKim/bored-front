<div class="page-sidebar bordered">
    <aside>
        <div class="navbar-collapse collapse">
            <div class="inner-box">
                @if(isset($themes) && is_array($themes) && count($themes) > 0)
                    <div class="categories-list  list-filter">
                        <h5 class="list-title"><strong>카테고리</strong></h5>
                        <ul class=" list-unstyled">
                            @foreach($themes as $key => $theme)
                                <li class="{{
                                ($theme['id'] == request()->segment(2)) || (isset($chooseTheme) && $theme['id'] == $chooseTheme['id']) ? "chooseLi" : ""
                                }}">
                                    <a class="app-genres"
                                       href="/theme/{{$theme['id']}}">
                                        {{$theme['title']}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--/.categories-list-->

                    <br>
                @endif

                @if(request()->segment(1) == 'theme' && request()->segment(2) != null)
                    <a class="btn btn-lg btn-primary btn-block"
                       href="/theme/{{request()->segment(2)}}/write">
                        글쓰기
                    </a>
                    <br/>
                @endif

                <div style="clear:both"></div>
            </div>
        </div>
        <!--/.categories-list-->
    </aside>
</div>