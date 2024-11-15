@extends('retro/layouts/app')

@section('title', 'Main Page')

@section('content')
    <div class="container">
        <div class="row col-sm-4">
            @include('retro/layouts/sidebar')
            <!--/.page-side-bar-->
        </div>

        <div class="row col-sm-8">
            <div class=" page-content col-thin-left bordered">

                <form action="/search/" method="get" onsubmit="ga('send', 'event', 'appslist', 'dosearch');">
                    <div class="search-row-wrapper">
                        <div class="container text-center">

                            <div class="col-sm-5">
                                <input class="form-control keyword" name="q" type="text"
                                       placeholder="e.g. Instagram">
                            </div>


                            <div class="col-sm-2 hidden-xs">
                                <button class="btn btn-block btn-primary"
                                        onclick="ga('send', 'event', 'appslist', 'searchbtn');"><i
                                            class="fa fa-search">검색하기</i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>

                <div class="category-list">
                    <br>

                    <!--/.listing-filter-->

                    <div class="adds-wrapper">

                        @if(isset($posts))
                            @foreach($posts as $key => $post)
                                <a class="app-line" onclick="ga('send', 'event', 'appslist', 'goSite');"
                                   href="/board/<?=$post['id']?>">
                                    <div class="item-list row">

                                        <div class="col-sm-1 " style="width: 40px;">
                                            <div class="add-image app-icon">
                                                <img class=" no-margin app-icon-pixelated"
                                                     src="https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?url=http://is2.mzstatic.com/image/thumb/Purple2/v4/b0/c1/9e/b0c19eb5-e576-f668-fa81-bd08c16d874e/mzl.qucuygly.png/100x100bb-85.jpg&container=focus&resize_w=15&resize_h=15&refresh=2592000"
                                                     alt="img">
                                            </div>
                                        </div>
                                        <!--/.photobox-->
                                        <div class="col-sm-7 right-border">
                                                <?= $post['title'] ?>
                                        </div>

                                        <div class="col-sm-2 right-border">
                                                <?= date('Y-m-d', strtotime($post['createdAt'])) ?>
                                        </div>

                                        <div class="col-sm-1 ">
                                            <h2 class="item-price">

                                                <span style="color: #00733e"><?= $post['ip'] ?></span>
                                            </h2>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif

                    </div> <!--/.adds-wrapper-->
                </div>

                @include('retro/layouts/paginate')
                <!--/.pagination-bar -->

            </div>
            <!--/.page-content-->
        </div>
    </div>
@endsection