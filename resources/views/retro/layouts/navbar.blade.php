<nav id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">심심할땐? Bored v.0.1</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-expanded="false"><span style="color: #fefe54">L</span>anguage <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="ga('send', 'event', 'main', 'lngchange');"
                               href="#">한국</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-expanded="false">
                        @if(isset($chooseRegion) && $chooseRegion != null)
                            <span style="color: #fefe54">{{$chooseRegion['title']}}</span>
                        @else
                            <span style="color: #fefe54">R</span>egion
                        @endif
                         <span class="caret"></span>
                    </a>
                    @if(isset($regions) && is_array($regions) && count($regions) > 0)
                        <ul class="dropdown-menu" role="menu">
                            @foreach($regions as $key => $region)
                                <li>
                                    <a href="/region/{{$region['id']}}">{{$region['title']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(!isset($userData) || $userData['accessToken'] === null)
                    <li>
                        <a href="#" data-toggle="modal" data-target="#loginModal"><span style="color: #fefe54">L</span>ogIn</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#signUpModal"><span style="color: #fefe54">S</span>ignUp</a>
                    </li>
                @else
                    <li>
                        <a href="#" data-toggle="modal" data-target="#logoutModal"><span style="color: #fefe54">L</span>ogOut</a>
                    </li>
                @endif
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</nav>
