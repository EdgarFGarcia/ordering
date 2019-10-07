{!! Theme::asset()->add('semantic-ui-semantic.reset.min', URL('/').'/semantic-ui/components/reset.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.site.min', URL('/').'/semantic-ui/components/site.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.container.min', URL('/').'/semantic-ui/components/container.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.grid.min', URL('/').'/semantic-ui/components/grid.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.image.min', URL('/').'/semantic-ui/components/image.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.menu.min', URL('/').'/semantic-ui/components/menu.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.divider.min', URL('/').'/semantic-ui/components/divider.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.segment.min', URL('/').'/semantic-ui/components/segment.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.form.min', URL('/').'/semantic-ui/components/form.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.input.min', URL('/').'/semantic-ui/components/input.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.button.min', URL('/').'/semantic-ui/components/button.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.list.min', URL('/').'/semantic-ui/components/list.min.css') !!}
{!! Theme::asset()->add('semantic-ui-semantic.message.min', URL('/').'/semantic-ui/components/message.min.css') !!}

{!! Theme::asset()->add('css-getLogin', URL('/').'/themes/default/assets/css/getLogin.css') !!}
{!! Theme::asset()->add('js-getLogin', URL('/').'/themes/default/assets/js/getLogin.js') !!}




<div id="divLogin" class="ui middle aligned center aligned grid transition hidden" style="height: 100vh !important;">
    <div class="column">
        {{--<h2 class="ui black image header">--}}
        {{--<img src="{{ URL::to('images/vc_logov2.png') }}" class="image">--}}
        {{--<div class="content">--}}
        {{--System Management--}}
        {{--</div>--}}

        {{--</h2>--}}
        <h2 class="ui icon header">
            <img src="{{ URL::to('img/vc_logov2.png') }}" class="image icon">
            <div class="content">
                Guest helpdesk
                {{--<div class="sub header">Manage your account settings and set e-mail preferences.</div>--}}
            </div>
        </h2>
        <form class="ui large form" action="login" method="POST">

            <div class="ui stacked segment">
                <h4 class="ui dividing header">Login to your account</h4>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="ui fluid large red submit button">Login</div>
            </div>

            <div class="ui error message"></div>
            {{ csrf_field() }}
        </form>

        <div class="ui message">
            No access? <a href="#">Request</a>
        </div>
    </div>
</div>