{!! Theme::asset()->add('angular-home',URL('/').'/themes/default/assets/js/myFoodList.js') !!}
{{--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--}}
<style>
    .hidden {
        display: none !important;
    }
</style>
<div ng-controller="homeController as homeControllerChild">

    <input type="hidden" id="roomNo" value="{!! $roomNo !!}" />
    <button id="bugfix" ng-click="" class="hidden"></button>





    <div id="mainContent" class="" style="">
        <div class="ui top fixed menu">
            <div ng-click="menuList()" class="item">
                <i class="align justify icon"></i>
            </div>
            <div id="menuForFoodOrder" class="right menu menuOption">

            </div>

        </div>
        <br/>
        <br/>
        <br/>
        <div id="foodList" class="">
            a
        </div>
    </div>

</div>

<script>

</script>