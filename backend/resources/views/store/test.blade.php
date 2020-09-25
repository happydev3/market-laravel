@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.user_royalty') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>Indirizzi del Negozio</h4>
            <a href="#" class="button mid-short primary">Aggiungi Indirizzo</a>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full not-padded not-spaced">
                <h4>Indirizzi</h4>
                <hr class="line-separator">

                <div class="profile-notification">
                    <!-- NOTIFICATION CLOSE -->
                    <div class="notification-close"></div>
                    <!-- NOTIFICATION CLOSE -->
                    <div class="profile-notification-date">
                        <p>2 Hours ago</p>
                    </div>
                    <div class="profile-notification-body">
                        <figure class="user-avatar">
                            <img src="images/avatars/avatar_02.jpg" alt="user-avatar">
                        </figure>
                        <p><span>MeganV.</span> added <span>Pixel Diamond Gaming Shop</span> to favourites</p>
                    </div>
                    <div class="profile-notification-type">
                        <span class="type-icon icon-heart primary"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.total_income')</h4>
                <hr class="line-separator">
                <div class="colors-pie-chart-wrap">
                    <canvas id="colors-pie-chart"></canvas>
                    <!-- CHART DESCRIPTION -->
                    <div class="chart-description">
                        <p class="text-header">{{number_format(100.23,2)}}€</p>
                        <p class="text-header">@lang('store_panel.royality_income')</p>
                    </div>
                </div>
            </div>
        </div> <!-- /FORM BOX ITEM -->
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/chart.min.js')}}"></script>
    <script src="{{URL::to('js/vendor/jquery.xmpiechart.min.js')}}"></script>
    <script src="{{URL::to('js/dashboard-statistics.js')}}"></script>
    <script>
        var ctx3 = $('#colors-pie-chart'),
            data3 = {
                type: 'doughnut',
                data: {
                    datasets: [
                        {
                            data: [100, 0, 0],
                            borderWidth: [ 0 , 0, 0 ],
                            backgroundColor: [
                                "#84c22d",
                                "#03f1b6",
                                "#108fe9"
                            ],
                            hoverBackgroundColor: [
                                "#90c23a",
                                "#03f1b6",
                                "#108fe9"
                            ]
                        }
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    },
                    cutoutPercentage: 75
                }
            },
            colorsPieChart = new Chart(ctx3, data3);
    </script>
@endsection