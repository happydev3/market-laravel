<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <title>@lang('admin.admin_login_title')</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <!-- Common CSS -->
    <link rel="stylesheet" href="{{URL::to('admin-res/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{URL::to('admin-res/fonts/icomoon/icomoon.css')}}" />
    <!-- Mian and Login css -->
    <link rel="stylesheet" href="{{URL::to('admin-res/css/main.css')}}" />
</head>

<body class="login-bg">
    <div class="container">
        <div class="login-screen row align-items-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <form action="{{ route('admin.login.submit') }}" method="POST">
                    {{csrf_field()}}
                    <div class="login-container">
                        <div class="row no-gutters">
                            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                                <div class="login-box">
                                    <a href="#" class="login-logo">
                                        <img src="{{URL::to('admin-res/img/logo.png')}}"/>
                                    </a>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="username"><i class="icon-account_circle"></i></span>
                                        <input type="text" class="form-control" name="email" placeholder="Email" aria-label="username" aria-describedby="username">
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="password"><i class="icon-verified_user"></i></span>
                                        <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="password">
                                    </div>
                                    <div class="actions clearfix">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                                <div class="login-slider"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="main-footer no-bdr fixed-btm">
        <div class="container">
            @lang('admin.admin_footer') {{\Illuminate\Support\Carbon::now()->year}}
        </div>
    </footer>
</body>

</html>