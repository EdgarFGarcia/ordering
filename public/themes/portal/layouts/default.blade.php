<!DOCTYPE html>
<html>
    <head>
        <title>{!! Theme::get('title') !!}</title>
        <meta charset="utf-8">
        <meta name="keywords" content="{!! Theme::get('keywords') !!}">
        <meta name="description" content="{!! Theme::get('description') !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        {!! Theme::asset()->styles() !!}
        {!! Theme::asset()->scripts() !!}
    </head>
    <style>
        .modalTo {
            margin-top: -122.5px !important;
        }
    </style>
    <body ng-app="MainApp">
    <input type="hidden" id="urlVal" value="{!! URL::to('/') !!}">
        {!! Theme::partial('header') !!}

        <div class="container">
            {!! Theme::content() !!}
        </div>

        {{--{!! Theme::partial('footer') !!}--}}
    <div id="RemoveConfi" class="ui basic modal modalTo">
        <div class="ui icon header">
            <i class="info icon"></i>
            Promo Code
        </div>
        <div class="content">
            <p>Order already inputed on POS?</p>
        </div>
        <div class="actions">
            <div class="ui red basic cancel inverted button">
                <i class="remove icon"></i>
                No
            </div>
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                Yes
            </div>
        </div>
    </div>{{--{!! Theme::partial('footer') !!}--}}
    <div id="RemoveCheckOut" class="ui basic modal modalTo">
        <div class="ui icon header">
            <i class="info icon"></i>
            Check-Out
        </div>
        <div class="content">
            <p>Room already SOA on POS?</p>
        </div>
        <div class="actions">
            <div class="ui red basic cancel inverted button">
                <i class="remove icon"></i>
                No
            </div>
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                Yes
            </div>
        </div>
    </div>
        {{--{!! Theme::partial('footer') !!}--}}
    <div id="approvedConfi" class="ui basic modal modalTo">
        <div class="ui icon header">
            <i class="info icon"></i>
            Order Confirmation
        </div>
        <div class="content">
            <p>Proceed this orders?</p>
        </div>
        <div class="actions">
            <div class="ui red basic cancel inverted button">
                <i class="remove icon"></i>
                No
            </div>
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                Yes
            </div>
        </div>
    </div>
    <div id="disapprovedConfi" class="ui basic modal modalTo">
        <div class="ui icon header">
            <i class="warning icon"></i>
            Order Cancellation
        </div>
        <div class="content">
            <p>Cancel this orders?</p>
        </div>
        <div class="actions">
            <div class="ui red basic cancel inverted button">
                <i class="remove icon"></i>
                No
            </div>
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                Yes
            </div>
        </div>
    </div>
    <div id="employeeRemoveConfi" class="ui basic modal modalTo">
        <div class="ui icon header">
            <i class="warning icon"></i>
            Order Confirmation
        </div>
        <div class="content">
            <p>Order already inputed on POS?</p>
        </div>
        <div class="actions">
            <div class="ui red basic cancel inverted button">
                <i class="remove icon"></i>
                No
            </div>
            <div class="ui green ok inverted button">
                <i class="checkmark icon"></i>
                Yes
            </div>
        </div>
    </div>

        {!! Theme::asset()->container('footer')->scripts() !!}
    </body>
</html>
