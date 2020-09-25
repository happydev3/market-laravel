<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="IbronTech - Elhan Ibraimi">
    @include('google_analytics')
    <link rel="stylesheet" href="{{URL::to('css/vendor/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/vendor/tooltipster.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/vendor/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/vendor/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/css/main.css')}}">

    @yield('custom_css')
    <!-- favicon -->
    <link rel="icon" href="{{URL::to('images/favicon.png')}}">
    <title>@yield('page_title')</title>
</head>
<body>
@include('marketplace.components.header')
@include('marketplace.components.side_menu')
@include('marketplace.components.main_menu')
@yield('page_content')

@if(Auth::check() == false)
    @include('marketplace.components.newsletter_banner')
@endif
@include('marketplace.components.footer')
<div class="shadow-film closed"></div>
@include('marketplace.components.svg_spec')

<!-- jQuery -->
<script src="{{URL::to('js/vendor/jquery-3.1.0.min.js')}}"></script>
<!-- Tooltipster -->
<script src="{{URL::to('js/vendor/jquery.tooltipster.min.js')}}"></script>
<!-- Owl Carousel -->
<script src="{{URL::to('js/vendor/owl.carousel.min.js')}}"></script>
<!-- Tweet -->
<!-- xmAlerts -->
<script src="{{URL::to('js/vendor/jquery.xmalert.min.js')}}"></script>
<!-- Side Menu -->
<script src="{{URL::to('js/side-menu.js')}}"></script>
<!-- Home -->
<script src="{{URL::to('js/home.js')}}"></script>
<!-- Tooltip -->
<script src="{{URL::to('js/tooltip.js')}}"></script>
<!-- User Quickview Dropdown -->
<script src="{{URL::to('js/user-board.js')}}"></script>
<!-- Home Alerts -->
<!--<script src="js/home-alerts.js"></script> -->

<!-- Footer -->
<script src="{{URL::to('js/footer.js')}}"></script>
<script>
    $('#tnxMsg').hide();
    $('#newsletterSubscrieBtn').click(function(e){
        e.preventDefault();
        var mail = $('#subscribe_email').val();
        if(mail != ""){
            $.post("{{route('marketplace.newsletter_subscribe')}}",{
                     _token: "{{csrf_token()}}",
                    subscribe_email : mail,
            },
            function(data,status){
               $('#tnxMsg').show();
            });
        }
    });
</script>

@if(\Illuminate\Support\Facades\Cookie::get('fb_cookie_accept') == false)
    <script>
        (function($) {
            $('body').xmalert({
                x: 'right',
                y: 'bottom',
                xOffset: 30,
                yOffset: 30,
                alertSpacing: 40,
                fadeDelay: 0.3,
                autoClose: false,
                template: 'survey',
                title: "@lang('pages_text.welcome_freeback')",
                paragraph: '@lang('pages_text.welcome_freeback_cookie')',
                timestamp: '',
                imgSrc: '{{URL::to('images/logo_mobile.png')}}',
                buttonSrc: [ "{{route('marketplace.accept.cookie')}}" ],
                buttonText: '@lang("pages_text.accept_cookies_btn")',
            });
        })(jQuery);
    </script>
@endif
@yield('custom_js')

</body>
</html>
