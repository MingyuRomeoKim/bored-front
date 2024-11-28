@extends('retro/layouts/app')

@section('title', 'Main Page')

@section('content')
    <div class="container">
        @foreach($regions as $key => $region)
            <div class="row col-sm-12">
                <div class=" page-content col-thin-left bordered">
                    <div class="category-header">
                        <h1><?= $region['title'] ?></h1>
                    </div>
                    @foreach($region['themes'] as $key => $theme)
                        <div class="adds-wrapper">
                            <a class="app-line" onclick="ga('send', 'event', 'appslist', 'goSite');"
                               href="/region/{{$region['titleEn']}}/theme/{{$theme['titleEn']}}">
                                <div class="item-list row">

                                    <div class="col-sm-2 " style="width: 40px;">
                                        <div class="add-image app-icon">
                                            <img class=" no-margin app-icon-pixelated"
                                                 src="https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?url=http://is2.mzstatic.com/image/thumb/Purple2/v4/b0/c1/9e/b0c19eb5-e576-f668-fa81-bd08c16d874e/mzl.qucuygly.png/100x100bb-85.jpg&container=focus&resize_w=15&resize_h=15&refresh=2592000"
                                                 alt="img">
                                        </div>
                                    </div>
                                    <!--/.photobox-->
                                    <div class="col-sm-3 right-border">
                                            <?= $theme['title'] ?>
                                    </div>

                                    <div class="col-sm-6">
                                            <?= $theme['description'] ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="row col-sm-12">
            @include('retro.layouts.posts')
        </div>
    </div>
@endsection