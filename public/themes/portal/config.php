<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
            $theme->setTitle('Guest Help desk ©  2017 - Victoria Court');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     <ul class="breadcrumb">
            //     @foreach ($crumbs as $i => $crumb)
            //         @if ($i != (count($crumbs) - 1))
            //         <li><a href="{{ $crumb["url"] }}">{!! $crumb["label"] !!}</a><span class="divider">/</span></li>
            //         @else
            //         <li class="active">{!! $crumb["label"] !!}</li>
            //         @endif
            //     @endforeach
            //     </ul>
            // ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {
            $theme->asset()->add('js-jquery-1.12.4.min', URL('/').'/js/jquery-1.12.4.min.js');
            $theme->asset()->add('js-angular.min', URL('/').'/js/angular-1.5.8/angular.min.js');
            $theme->asset()->add('js-myvclifemain', URL('/').'/js/main.js');

            $theme->asset()->add('css-semantic.css', URL('/').'/semantic-ui/semantic.css');
            $theme->asset()->add('css-semantic.js', URL('/').'/semantic-ui/semantic.js');


            $theme->asset()->add('css-jquery.datetimepicker', URL('/').'/css/jquery.datetimepicker.css');
            $theme->asset()->add('jquery-jquery.datetimepicker', URL('/').'/js/jquery.datetimepicker.js');
//            $theme->asset()->add('angular-dirPagination', URL('/').'/js/dirPagination.js');
            $theme->asset()->add('angular-underscore.min', URL('/').'/js/underscore.min.js');

            $theme->asset()->add('node-socket.io', URL('/').'/js/socket.io.js');
            $theme->asset()->add('node-client', URL('/').'/js/client.js');

            $theme->asset()->add('css-main.css', URL('/').'/css/main.css');
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => array(

            'default' => function($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }

        )

    )

);