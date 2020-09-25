@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.user_royalty') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.royality_fees_panel_title')  - @lang('store_panel.royality_fee_code') {{Auth::user()->own_referral_code}}</h4>
            <a href="mailto:?subject=@lang('user_panel.invite_mail_subject')&body=@lang('user_panel.invite_mail_content') {{Auth::user()->name}},
             @lang('user_panel.invite_mail_content2') {{Auth::user()->own_referral_code}}" class="button mid-short primary">@lang('user_panel.invite_friend_btn')</a>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full not-padded not-spaced">
                <h4>@lang('store_panel.invited_users') ({{$total_users}})</h4>
                <hr class="line-separator">
                <!-- RECENT ACTIVITY -->
                <div class="recent-activity">
                    @foreach($users as $user)
                        <div class="recent-activity-item">
                            <span class="sl-icon icon-user"></span>
                            <div class="recent-activity-item-timestamp">
                                <p>{{$user->created_at->format('d/m/20y')}}</p>
                            </div>
                            <div class="recent-activity-item-info">
                                <figure class="user-avatar small">
                                     <img src="{{URL::to($user->userAvatarLink())}}" alt="user-image">
                                </figure>
                                <p>{{$user->name}}</p>
                            </div>
                            <!-- CLOSE ICON -->
                            <!-- /CLOSE ICON -->
                        </div>
                        <!-- /RECENT ACTIVITY ITEM -->
                    @endforeach
                </div>
                <!-- /RECENT ACTIVITY -->
                {{$users->links()}}
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
                        <p class="text-header">{{number_format($total_royalty,2)}}€</p>
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