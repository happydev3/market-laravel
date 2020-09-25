<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('google_analytics')
    <title>@lang('page_titles.register_page_title')</title>

    <link rel="shortcut icon" href="{{URL::to('css/auth/images/logo/favicon.png')}}">
    <!-- core dependcies css -->
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
                        <h1 class="font-weight-light font-size-35 text-white">@lang('auth.store_login_title')</h1>
                        <p class="text-white width-70 text-opacity m-t-25 font-size-16">@lang('auth.store_login_desc') @lang('auth.store_login_desc1')</p>
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

                                <form id="store-register-form" method="POST" action="{{route('store.register.submit')}}">
                                    {{csrf_field()}}

                                    <div class="form-group">
                                        <input type="text" name="business_name" value="{{old('business_name')}}" class="form-control @if($errors->has('business_name')) error @endif" placeholder="@lang('auth.business_name_placeholder')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="vat_number" value="{{old('vat_number')}}" class="form-control @if($errors->has('vat_number')) error @endif" placeholder="@lang('auth.vat_number_placeholder')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="ae_code" value="{{old('ae_code')}}" class="form-control @if($errors->has('ae_code')) error @endif" placeholder="@lang('auth.ae_placeholder')">
                                    </div>

                                    <div class="form-group">
                                        <select name="store_category" class="form-control" id="store_category" required>
                                            <option disabled selected value="null">@lang('auth.store_cat_placeholder')</option>
                                            <option disabled value="null">------------</option>
                                            @foreach(\App\Models\StoreCategory::all() as $store_category)
                                                @if($store_category->name != "Generic")
                                                    <option value="{{$store_category->id}}">{{$store_category->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" value="{{old('email')}}" class="form-control @if($errors->has('email')) error @endif" placeholder="@lang('auth.email_label')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control @if($errors->has('password')) error @endif" placeholder="Password*" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control @if($errors->has('password')) error @endif" placeholder="@lang('auth.password_confirmation_label')" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone_number" value="{{old('phone_number')}}" class="form-control @if($errors->has('phone_number')) error @endif" placeholder="@lang('auth.phone_number_placeholder')">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="addr" name="formatted_address" class="form-control" placeholder="@lang('auth.street_address_placeholder')">
                                        <small>@lang('auth.use_autocomplete')</small>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="referral_code" value="@if(isset($referral)){{$referral}}@else{{old('referral_code')}}@endif"  class="form-control" placeholder="@lang('auth.referral_label')" @if(isset($referral)) hidden @endif id="referral">
                                        <small id="refError" hidden>@lang('auth.referral_code_invalid')</small>
                                    </div>

                                    <div class="form-group">
                                        <select name="store_type" class="form-control" id="store_type_select">
                                            <option value="null" selected disabled>@lang('auth.store_type_label')</option>
                                            <option value="online">@lang('auth.store_type_online')</option>
                                            <option value="physical">@lang('auth.store_type_offline')</option>
                                            <option value="both">@lang('auth.store_type_both')</option>
                                        </select>
                                    </div>
                                    <input  id="lat" name="lat" type="text" value="" style="display: none">
                                    <input  id="lng" name="lng" type="text" value="" style="display: none"><br/>

                                    <p class="m-b-15 font-size-13">@lang('auth.register_terms_acceptance_store_part1') <a href="{{route('marketplace.legal.seller_contract')}}" target="_blank">@lang('auth.register_terms_acceptance_link')</a> @lang('auth.register_terms_acceptance_store_part2')</p>
                                    <button id="store_register_submit" class="btn btn-block btn-lg btn-gradient-danger">@lang('auth.register_button')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFVt2WccdiOFmDTQhNaahcgp_v5yUhMRA&language=it&libraries=places"></script>
<script src="{{ URL::to('js/vendor/jquery-3.1.0.min.js') }}"></script>
<script src="{{URL::to('js/jquery.geocomplete.min.js')}}"></script>
<script>
    $('#addr').geocomplete({
        country : "IT",
        details : "form",
        address : "{{old('formatted_address')}}",
    });

   $('#store_register_submit').click(function(e){
        e.preventDefault();
        if(($('#lat').val() == "") ||($('#lng').val() == "")) {
            alert("@lang('auth.provided_address_not_correct')")
        } else {
            if(($('#store_category').val =="null") || ($('#store_type_select').val() == "null")){
                alert("@lang('auth.select_store_category_alert')")
            } else {
                var refCode = $('#referral').val();
                if(refCode != ""){
                    $.ajax({ type: "GET",
                        url: "https://www.freeback.it/verify/referral/"+refCode,
                        success : function(text)
                        {
                            if(text == "valid"){
                                $('#store-register-form').submit();
                            }
                            else {
                                $('#referral').addClass("error");
                                $('#refError').removeAttr("hidden");
                            }
                        }
                    });
                } else {
                    $('#store-register-form').submit();
                }
            }
        }
    });
</script>
</body>
</html>