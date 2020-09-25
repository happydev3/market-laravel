<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('google_analytics')
    <title>@lang('page_titles.connect_droppay')</title>
    <link rel="stylesheet" href="{{URL::to('css/auth/bootstrap.css')}}"/>
    <link href="{{URL::to('css/auth/app.css')}}" rel="stylesheet">
</head>

<body>
<div class="app">
    <div class="layout bg-gradient-danger">
        <div class="container">
            <div class="row full-height align-items-center">
                <div class="col-md-7 d-none d-md-block">

                    <img class="img-fluid" src="{{URL::to('images/droppay.png')}}" alt="">

                    <div class="m-t-15 m-l-20">
                        <h1 class="font-weight-light font-size-35 text-white">@lang('auth.complete_register')</h1>
                        <p class="text-white width-70 text-opacity m-t-25 font-size-16">@lang('auth.connect_droppay_desc') <br/> @lang('auth.no_account_droppay')</p>
                        <div class="m-t-60">
                            <a href="{{route('marketplace.legal.terms')}}" target="_blank" class="text-white text-link m-r-15">@lang('footer.terms')</a>
                            <a href="https://www.drop-pay.com"  target="_blank" class="text-white text-link">DropPay ©</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-shadow">
                        <div class="card-body">
                            <div class="p-h-15 p-v-40">
                                <p style="padding: 14px" id="pullID" hidden>{{$connection_id}}</p>
                                <h2>@lang('auth.connect_droppay')</h2>
                                <p>@lang('auth.connect_droppay_desc')</p>
                                <p align="center" id="qrPlaceholder"></p>
                                <a href="https://www.drop-pay.com" target="_blank" class="btn btn-block btn-lg btn-gradient-danger">@lang('auth.no_droppay_btn')</a>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::to('js/vendor/jquery-3.1.0.min.js')}}"></script>
<script src="{{URL::to('js/vendor/qrcode.min.js')}}"></script>
<script>
    $( document ).ready(function() {
        var pullId= $('#pullID').text();
        var qrPlaceholder = new QRCode("qrPlaceholder");
        qrPlaceholder.makeCode("https://dp.link/u/20/"+ pullId);
    });
</script>
</body>
</html>