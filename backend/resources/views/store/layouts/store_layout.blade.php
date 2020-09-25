<!DOCTYPE html>
<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="IbronTech - Elhan Ibraimi">
    @include('google_analytics')
    <link rel="stylesheet" href="{{URL::to('css/vendor/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/style.css')}}">

    <link rel="stylesheet" href="{{URL::to('css/vendor/magnific-popup.css')}}">
@yield('custom_css')
<!-- favicon -->
    <link rel="icon" href="{{URL::to('images/favicon.png')}}">
    <title>@yield('page_title')</title>
</head>

<body>
@include('store.components.store_sidemenu')
<div class="dashboard-body">
    @include('store.components.store_topheader')
    <div class="dashboard-content">
        @yield('page_content')
    </div>
</div>
<!-- SVG ARROW -->
<svg style="display: none;">
    <symbol id="svg-arrow" viewBox="0 0 3.923 6.64014" preserveAspectRatio="xMinYMin meet">
        <path d="M3.711,2.92L0.994,0.202c-0.215-0.213-0.562-0.213-0.776,0c-0.215,0.215-0.215,0.562,0,0.777l2.329,2.329
			L0.217,5.638c-0.215,0.215-0.214,0.562,0,0.776c0.214,0.214,0.562,0.215,0.776,0l2.717-2.718C3.925,3.482,3.925,3.135,3.711,2.92z"/>
    </symbol>
</svg>
<!-- /SVG ARROW -->

<!-- SVG PLUS -->
<svg style="display: none;">
    <symbol id="svg-plus" viewBox="0 0 13 13" preserveAspectRatio="xMinYMin meet">
        <rect x="5" width="3" height="13"/>
        <rect y="5" width="13" height="3"/>
    </symbol>
</svg>
<!-- /SVG PLUS -->

<!-- SVG MINUS -->
<svg style="display: none;">
    <symbol id="svg-minus" viewBox="0 0 13 13" preserveAspectRatio="xMinYMin meet">
        <rect y="5" width="13" height="3"/>
    </symbol>
</svg>
<!-- /SVG MINUS -->

<!-- jQuery -->
<script src="{{URL::to('js/vendor/jquery-3.1.0.min.js')}}"></script>
<!-- XM Pie Chart -->
<script src="{{URL::to('js/vendor/jquery.xmpiechart.min.js')}}"></script>
<!-- Side Menu -->
<script src="{{URL::to('js/side-menu.js')}}"></script>
<!-- Dashboard Header -->
<script src="{{URL::to('js/dashboard-header.js')}}"></script>

<!-- xmAlert -->
<script src="{{URL::to('js/vendor/jquery.xmalert.min.js')}}"></script>
<!-- Magnific Popup -->
<script src="{{URL::to('js/vendor/jquery.magnific-popup.min.js')}}"></script>

<script>
    $(document).ready(function(){
        sendRequest();
        function sendRequest(){
            $.ajax({
                url: "{{route('store.notifications')}}",
                success: function(data){
                    if(data.length > 0) {
                        $.each(data, function(k,v) {
                                $('body').xmalert({
                                    x: 'right',
                                    y: 'top',
                                    xOffset: 30,
                                    yOffset: 30,
                                    alertSpacing: 40,
                                    lifetime: 8500,
                                    fadeDelay: 0.3,
                                    template: 'messageSuccess',
                                    title: "@lang('store_panel.transaction_notification_title')" + v.full_import + "€",
                                    paragraph: "@lang('store_panel.transaction_notification_text')",
                                });
                        });

                    }
                },
            });

            $.ajax({
                url: "{{route('store.cash.ajax')}}",
                success: function(data){
                    if(data.length > 0) {
                        $.each(data, function(k,v) {
                            $('body').xmalert({
                                x: 'right',
                                y: 'top',
                                xOffset: 30,
                                yOffset: 30,
                                alertSpacing: 40,
                                lifetime: 8500,
                                fadeDelay: 0.3,
                                template: 'messageInfo',
                                title: "@lang('store_panel.cash_transaction_notifiication_title')" + v.full_import + "€",
                                paragraph: "@lang('store_panel.cash_transaction_notification_text')" + " @lang('store_panel.cash_transactions')",
                            });
                        });

                    }
                },
                complete: function () {
                    setInterval(sendRequest(),4500);
                }
            });
        }
    });
</script>
@yield('custom_js')
</body>
</html>