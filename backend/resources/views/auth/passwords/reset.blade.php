<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('google_analytics')
    <title>@lang('page_titles.password_recovery_page_title')</title>

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
                                    <h2 class="inline-block pull-right m-v-0 p-t-15">@lang('pages_text.password_recovery_form_title')</h2>
                                </div>
                                @foreach ($errors->all() as $error)
                                    <p  class="m-t-15 font-size-13" style="color:red">{{ $error }}</p>
                                @endforeach
                                <form method="POST" action="{{ route('password.request') }}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <p>@lang('pages_text.pwd_reset_guideline')</p><br/>

                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control @if($errors->has('email')) error @endif" placeholder="@lang('auth.email_label')" value="{{$email or old('email')}}" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control @if($errors->has('password')) error @endif" placeholder="@lang('auth.password_label')"  required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control @if($errors->has('password')) error @endif" placeholder="@lang('auth.password_confirmation_label')"  required>
                                    </div>

                                    <div class="m-t-20 text-right">
                                        <button type="submit" class="btn btn-gradient-danger">@lang('auth.recover_password_btn')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{URL::to('auth/js/vendor.js')}}"></script>

<script src="{{URL::to('auth/js/app.min.js')}}"></script>

<!-- page js -->

</body>
</html>

