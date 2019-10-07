<!DOCTYPE html>
<html>
    <head>
        <title>Login Attempts Exceeded.</title>

    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Login failed attempts exceeded.</div>
                <div class="title">You are now locked out for 5 minutes.</div>
                <a href="{{ url('/') }}" class="gotit">Try Again.</a>
            </div>
        </div>
    </body>
</html>
