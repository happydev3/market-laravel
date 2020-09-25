<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="IBRONTECH - Elhan Ibraimi ©" />
    <link rel="shortcut icon" href="img/favicon.ico" />
    <title>@yield('page_title')</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Common CSS -->
    <link rel="stylesheet" href="{{URL::to('admin-res/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{URL::to('admin-res/fonts/icomoon/icomoon.css')}}" />
    <link rel="stylesheet" href="{{URL::to('admin-res/css/main.css')}}" />
    @yield('custom_css')

</head>

<body>
    <div class="app-wrap">
        @include('admin.components.header')
        <div class="app-container">
            @include('admin.components.side_menu')
            <div class="app-main">
                @yield('page_content')
            </div>
        </div>
        @include('admin.components.footer')
    </div>
    <!-- jQuery first, then Tether, then other JS. -->
    <script src="{{URL::to('admin-res/js/jquery.js')}}"></script>
    <script src="{{URL::to('admin-res/js/tether.min.js')}}"></script>
    <script src="{{URL::to('admin-res/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/unifyMenu/unifyMenu.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/onoffcanvas/onoffcanvas.js')}}"></script>
    <script src="{{URL::to('admin-res/js/moment.js')}}"></script>
    <!-- Common JS -->
    <script src="{{URL::to('admin-res/js/common.js')}}"></script>
    @yield('custom_js')

</body>
</html>




