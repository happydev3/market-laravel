<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('google_analytics')
    <title>@lang('page_titles.register_page_title')</title>

    <link rel="stylesheet" href="{{URL::to('css/auth/bootstrap.css')}}"/>
    <link href="{{URL::to('css/auth/app.css')}}" rel="stylesheet">
</head>

<body>
<div class="app">
    <div class="layout bg-gradient-danger">
        <div class="container">
            <div class="row full-height align-items-center">
                <div class="col-md-7 d-none d-md-block">
                    <img class="img-fluid" src="{{URL::to('css/auth/images/logo/logo-white.png')}}" alt="">
                    <div class="m-t-15 m-l-20">
                        <h1 class="font-weight-light font-size-35 text-white">@lang('auth.login_form_title')</h1>
                        <p class="text-white width-70 text-opacity m-t-25 font-size-16">@lang('auth.login_form_desc') @lang('auth.login_form_desc2')</p>
                        <div class="m-t-60">
                            <a href="{{route('marketplace.legal.terms')}}" class="text-white text-link m-r-15">@lang('footer.terms')</a>
                            <a href="{{route('marketplace.legal.faq')}}" class="text-white text-link">@lang('footer.faqs')</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <div class="p-h-15 p-v-40">
                                <h2>@lang('auth.register_form_title')</h2>
                                @foreach ($errors->all() as $error)
                                    <p class="m-b-15 font-size-13" style="color: red;">{{$error}}</p>
                                @endforeach

                                <form action="{{route('register')}}" method="post" id="registerForm">
                                    {{csrf_field()}}

                                    <div class="form-group">
                                        <input type="text" name="name" value="{{old('name')}}" class="form-control @if($errors->has('name')) error @endif" placeholder="@lang('auth.name_label')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" value="{{old('email')}}" class="form-control @if($errors->has('email')) error @endif" placeholder="@lang('auth.email_label')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone_no" value="{{old('phone_no')}}" class="form-control @if($errors->has('phone_no')) error @endif" placeholder="@lang('auth.phone_label')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control @if($errors->has('password')) error @endif" placeholder="Password*" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control @if($errors->has('password')) error @endif" placeholder="@lang('auth.password_confirmation_label')" required>
                                    </div>

                                    <div class="form-group">
                                        <select name="city_id" class="form-control">
                                            <option disabled selected>@lang('auth.city_placeholder')</option>
                                            <option disabled>------------</option>
                                            @foreach(App\Models\City::orderBy('city_name','ASC')->get() as $city )
                                                <option value="{{$city->id}}">{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <input type="text" name="referral_code" value="@if(isset($referral)){{$referral}}@else{{old('referral_code')}}@endif" class="form-control" placeholder="@lang('auth.referral_label')" @if(isset($referral)) hidden @endif id="referral">
                                        <small id="refError" hidden>@lang('auth.referral_code_invalid')</small>
                                    </div>
                                    <p class="m-b-15 font-size-13">@lang('auth.register_terms_acceptance')</p>
                                    <button class="btn btn-block btn-lg btn-gradient-danger" id="registerBtn">@lang('auth.register_button')</button>
                                    <p></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::to('js/vendor/jquery-3.1.0.min.js')}}"></script>
<script>
    $('#registerBtn').click(function(e){
        e.preventDefault();
        var refCode = $('#referral').val();
        if(refCode != ""){
            $.ajax({ type: "GET",
                    url: "https://www.freeback.it/verify/referral/"+refCode,
                    success : function(text)
                    {
                        if(text == "valid"){
                            $('#registerForm').submit();
                        }
                        else {
                            $('#referral').addClass("error");
                            $('#refError').removeAttr("hidden");
                        }
                    }
                });
        } else {
            $('#registerForm').submit();
        }
    });
</script>
</body>
</html>