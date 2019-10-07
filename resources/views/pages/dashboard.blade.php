{!! Theme::asset()->add('angular-home',URL('/').'/themes/default/assets/js/dashboard.js') !!}
{{--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--}}
<style>
    .hidden {
        display: none !important;
    }
</style>
<div ng-controller="homeController as homeControllerChild">

    <input type="hidden" id="roomNo" value="{!! $roomNo !!}" />
    <button id="bugfix" ng-click="" class="hidden"></button>




    <div id="loading" class="ui fixed vertical hidden" style="width: 100%;padding-top: 18vh;text-align: center;">
        <img class="ui middle aligned large image" src="{!! URL('/img/logo.png') !!}" style="margin: auto 0;">
        <h1>Welcome to Victoria Court</h1>
    </div>
    <div id="mainContent" class="hidden" style="">
        <div class="ui top fixed menu">
            <div ng-click="menuList()" class="item">
                <i class="align justify icon"></i>
            </div>
            <div id="menuForFoodOrder" class="right menu menuOption">

            </div>

        </div>
        <br/>
        <br/>
        <div id="foodList" class="">



            <div class="demo-wrapper">
                <!-- classnames for the pages should include: 1) type of page 2) page name-->
                <div class="s-page random-restored-page">
                    <div class="page-content">
                        <h2 class="page-title">Some minimized App</h2>
                    </div>
                    <div class="close-button s-close-button">x</div>
                </div>
                <div class="s-page custom-page">
                    <div class="page-content">
                        <h2 class="page-title">Thank You!</h2>
                    </div>
                    <div class="close-button s-close-button">x</div>
                </div>
                <div class="r-page random-r-page">
                    <div class="page-content">
                        <h2 class="page-title">App Screen</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae a nesciunt hic animi iure laborum vitae maiores blanditiis non voluptate similique vel earum cumque nostrum voluptas illo minus alias fugiat.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam aliquid distinctio eum neque provident doloremque nostrum totam assumenda repellat repudiandae perferendis facilis voluptatem praesentium dignissimos impedit cumque tempore id quaerat.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus sint officia deleniti omnis asperiores nihil voluptatem maxime labore inventore consequatur ipsa nobis officiis laudantium cum provident quo tempore temporibus corporis.</p>
                    </div>
                    <div class="close-button r-close-button">x</div>
                </div>
                <!--each tile should specify what page type it opens (to determine which animation) and the corresponding page name it should open-->
                <div class="dashboard clearfix">
                    <ul class="tiles">
                        <div class="col1 clearfix">
                            <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
                                <div><p>This tile's content slides up</p></div>
                                <div><p>View all tasks</p></div>
                            </li>
                            <li class="tile tile-small tile tile-2 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
                                <div><p class="icon-arrow-right"></p></div>
                                <div><p>Tile's content slides right. Page opens from left</p></div>
                            </li>
                            <li class="tile tile-small last tile-3" data-page-type="r-page" data-page-name="random-r-page">
                                <p class="icon-calendar-alt-fill"></p>
                            </li>
                            <li class="tile tile-big tile-4 fig-tile" data-page-type="r-page" data-page-name="random-r-page">
                                <figure>
                                    <img src="http://sarasoueidan.com/demos/windows8-animations/images/blue.jpg" />
                                    <figcaption class="tile-caption caption-left">Slide-out Caption from left</figcaption>
                                </figure>
                            </li>
                        </div>

                        <div class="col2 clearfix">
                            <li class="tile tile-big tile-5" data-page-type="r-page" data-page-name="random-r-page">
                                <div><p><span class="icon-cloudy"></span>Weather</p></div>
                            </li>
                            <li class="tile tile-big tile-6 slideTextLeft" data-page-type="r-page" data-page-name="random-r-page">
                                <div><p><span class="icon-skype"></span>Skype</p></div>
                                <div><p>Make a Call</p></div>
                            </li>
                            <!--Tiles with a 3D effect should have the following structure:
                                1) a container inside the tile with class of .faces
                                2) 2 figure elements, one with class .front and the other with class .back-->
                            <li class="tile tile-small tile-7 rotate3d rotate3dX" data-page-type="r-page" data-page-name="random-r-page">
                                <div class="faces">
                                    <div class="front"><span class="icon-picassa"></span></div>
                                    <div class="back"><p>Launch Picassa</p></div>
                                </div>
                            </li>
                            <li class="tile tile-small last tile-8 rotate3d rotate3dY" data-page-type="r-page" data-page-name="random-r-page">
                                <div class="faces">
                                    <div class="front"><span class="icon-instagram"></span></div>
                                    <div class="back"><p>Launch Instagram</p></div>
                                </div>
                            </li>
                        </div>

                        <div class="col3 clearfix">
                            <li class="tile tile-2xbig tile-9 fig-tile" data-page-type="custom-page" data-page-name="random-r-page">
                                <figure>
                                    <img src="http://sarasoueidan.com/demos/windows8-animations/images/summer.jpg" />
                                    <figcaption class="tile-caption caption-bottom">Fixed Caption: Some Subtitle or Tile Description Goes Here with some kinda link or anything
                                </figure>
                            </li>
                            <li class="tile tile-big tile-10" data-page-type="s-page" data-page-name="custom-page">
                                <div><p>Windows-8-like Animations with CSS3 &amp; jQuery &copy; Sara Soueidan. Licensed under MIT.</p></div>
                            </li>
                        </div>
                    </ul>
                </div><!--end dashboard-->

            </div>

        </div>
    </div>

</div>

<script>
    $(".dropdown").dropdown();
    $("#bugfix")
            .popup({
                on       : 'click',
                position : 'bottom right',
                target   : '#orderButton',
                title    : 'Cart updated',
                content  : '',
                delay: {
                    show: 100,
                    hide: 100
                }
            })
    ;
</script>