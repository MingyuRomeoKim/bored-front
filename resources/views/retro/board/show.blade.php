@extends('retro/layouts/app')

@section('main', 'Main Page')

@section('content')
    <div class="container">
        <div class="row">

            @include('retro/layouts/sidebar')
            <!--/.page-side-bar-->

            @if(isset($post))
            <div class="col-sm-8 page-content col-thin-left bordered">

                <div class="row">
                    <div class="col-sm-8">


                        <div class="row">
                            <div class="col-sm-2">
                                <div class="add-image app-icon">
                                    <img class=" no-margin app-icon-pixelated" src="https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?url=http://is2.mzstatic.com/image/thumb/Purple111/v4/f9/76/af/f976af9f-95d1-e5a8-6edb-5c84bdd68fc9/PlayerIcon.png/100x100bb-85.jpg&amp;container=focus&amp;resize_w=25&amp;resize_h=25&amp;refresh=2592000" alt="img">
                                </div>
                            </div>

                            <div class="col-sm-8">

                                <h1><?=$post['title']?></h1>

                                <i class="fa fa-money" style="width: 18px;"></i>

                                <?=$post['ip']?>
                                <br>
                                <i class="fa fa-user" style="width: 18px;"></i> Developer:
                                <a href="https://softwar.io/developers/618105376-peaksel"><?=$post->user->name?></a><br>
                                <br>

                                <a class="btn btn-block btn-primary" href="mailto:<?=$post->user->email?>" target="_blank">Mail 보내기 </a>


                            </div>

                        </div>





                        <br>




                        <p class="intro">
                            <?=$post->content?>
                        </p>


                    </div>

                    <div class="col-sm-4">
                        <div id="home-slideshow" class="owl-carousel owl-theme add-image app-icon">

                            <div class="item"><img class="img-responsive app-screenshort" src="https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy?url=https://is2-ssl.mzstatic.com/image/thumb/Purple111/v4/10/26/46/10264661-ba4e-497e-5ba5-02bae513fd34/pr_source.png/800x500bb.png&amp;container=focus&amp;resize_w=120&amp;resize_h=200&amp;refresh=2592000" alt=""></div>


                        </div>

                    </div>

                </div>

            </div>
            @endif
            <!--/.page-content-->

        </div>


    </div>
@endsection