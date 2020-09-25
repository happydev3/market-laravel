<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('google_analytics')
    <title>@lang('page_titles.login_page_title')</title>

    <link rel="shortcut icon" href="auth/images/logo/favicon.png">

    <link rel="stylesheet" href="{{URL::to('css/auth/bootstrap.css')}}"/>
    <link href="{{URL::to('css/auth/materialdesignicons.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/auth/animate.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/auth/app.css')}}" rel="stylesheet">
</head>

<body>
<div class="app">
    <div class="layout bg-gradient-danger">
        <div class="container">
            <div class="row full-height align-items-center">
                <div class="col-md-5 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-15">
                                <div class="m-b-30">
                                    <img class="img-responsive inline-block" src="{{URL::to('css/auth/images/logo/logo.png')}}" alt="">
                                    <h2 class="inline-block pull-right m-v-0 p-t-15">@lang('pages_text.user_area')</h2>
                                </div>
                                @foreach ($errors->all() as $error)
                                    <p  class="m-t-15 font-size-13" style="color:red">{{ $error }}</p>
                                @endforeach
                                <form action="{{route('login')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control @if($errors->has('email')) error @endif" placeholder="@lang('auth.email_label')" value="{{old('email')}}" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <div class="checkbox font-size-13 d-inline-block p-v-0 m-v-0">
                                        <input id="agreement" name="remember" type="checkbox">
                                        <label for="agreement">@lang('auth.keep_me_logged')</label>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{route('password.request')}}">@lang('auth.forgot_password')</a>
                                    </div>
                                    <div class="m-t-10 text-right">
                                        <button type="submit" class="btn btn-gradient-danger">@lang('auth.login_button')</button>
                                    </div>
                                </form>
                                <br/>
                                <p align="center">@lang('auth.login_register') <a href="{{ route('register') }}">@lang('auth.login_register_invite')</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


















