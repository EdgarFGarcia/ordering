<!DOCTYPE html>
<html>
    <head>
        <title>{!! Theme::get('title') !!}</title>
        <meta charset="utf-8">
        <meta name="keywords" content="{!! Theme::get('keywords') !!}">
        <meta name="description" content="{!! Theme::get('description') !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
        {!! Theme::asset()->styles() !!}
        {!! Theme::asset()->scripts() !!}
    </head>
    <body ng-app="MainApp">
    <input type="hidden" id="urlVal" value="{!! URL::to('/') !!}">
        {!! Theme::partial('header') !!}
        {{--aa--}}
{{--    {{  var_dump( Theme::getContentArguments()['roomNo'] ) }}--}}
    {{--{!! Theme::getContentArguments() !!}--}}
        <div id="mainContentDefault" class="ui fluid container ">
            {!! Theme::content() !!}
        </div>

        {{--{!! Theme::partial('footer') !!}--}}

        {!! Theme::asset()->container('footer')->scripts() !!}
    </body>
</html>
