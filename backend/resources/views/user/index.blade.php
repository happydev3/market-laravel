@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.user_home') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>{{Auth::user()->name}} - @lang('user_panel.dashboard')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- GRAPH STATS LIST -->
        <div class="graph-stats-list">
            <!-- GRAPH STATS LIST ITEM -->
            <div class="graph-stats-list-item green bars">
                <h2>{{number_format($todayAmount,2)}}€ </h2>
                <p class="text-header">@lang('user_panel.wallet_today_earnings')</p>
            </div>
            <!-- /GRAPH STATS LIST ITEM -->

            <!-- GRAPH STATS LIST ITEM -->
            <div class="graph-stats-list-item violet line">
                <h2>{{number_format($availableAmount,2)}}€</h2>
                <p class="text-header">@lang('user_panel.cashback_to_request')</p>
                <a href="{{route('user.cashback_request')}}" style="color:white">@lang('user_panel.cashback_require_url') </a>
            </div>
            <!-- /GRAPH STATS LIST ITEM -->

            <!-- GRAPH STATS LIST ITEM -->
            <div class="graph-stats-list-item blue step">
                <h2>{{number_format($totalCashback,2)}}€</h2>
                <p class="text-header">@lang('user_panel.wallet_overall_import')</p>
            </div>
            <!-- /GRAPH STATS LIST ITEM -->

            <!-- GRAPH STATS LIST ITEM -->
            <div class="graph-stats-list-item red curve">
                <h2>{{number_format($friendsAmount,2)}}€</h2>
                <p class="text-header">@lang('user_panel.wallet_royalty_incomes')</p>
            </div>
        </div>
        <!-- /GRAPH STATS LIST -->

        @if(!Auth::guard('web')->user()->paymentConfiguration->dp_connected)
            <div class="form-box-item full not-padded not-spaced">
                <h4>@lang('user_panel.news_freeback')</h4>
                <hr class="line-separator">
                <div class="recent-activity">
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-rocket"></span>
                        <div class="recent-activity-item-timestamp">
                            <p>{{ now()->format('d/m/20y - h:i') }}</p>
                        </div>
                        <div class="recent-activity-item-info">
                            <p><span class="bold">@lang('user_panel.create_dp_account') : </span> @lang('user_panel.create_dp_account_after') - <a href="https://www.drop-pay.com/it/home" style="color: #0ae7c2" target="_blank">@lang('user_panel.create_dp_account_after2')</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(!Auth::guard('web')->user()->isUserCompleted())
        <div class="form-box-item full not-padded not-spaced">
            <h4>@lang('user_panel.account_completion_title')</h4>
            <hr class="line-separator">
                <!-- RECENT ACTIVITY -->
            @if(!Auth::user()->email_verified)
                <div class="recent-activity">
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-rocket"></span>
                        <div class="recent-activity-item-timestamp">
                            <p>{{ now()->format('d/m/20y - h:i') }}</p>
                        </div>
                        <div class="recent-activity-item-info">
                            <p><span class="bold">@lang('user_panel.mail_verify_title') : </span> @lang('user_panel.mail_verify_missing') {{Auth::user()->email}} @lang('user_panel.mail_verify_missing2')</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(!Auth::user()->phone_verified)
                <div class="recent-activity">
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-rocket"></span>
                        <div class="recent-activity-item-timestamp">
                            <p>{{ now()->format('d/m/20y - h:i') }}</p>
                        </div>
                        <div class="recent-activity-item-info">
                            <p><span class="bold"><a href="{{route('user.verify_phone')}}">@lang('user_panel.phone_verify_missing')</a> : </span> @lang('user_panel.phone_verify_missing2') {{Auth::user()->phone_no}}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
        @endif



        <div class="form-box-item full not-padded not-spaced">
            <h4>@lang('user_panel.recent_activity')</h4>
            <hr class="line-separator">
            <!-- RECENT ACTIVITY -->
            <div class="recent-activity">
                @if(count($notifications) > 0 )
                    @foreach($notifications as $notification)
                        <div class="recent-activity-item">
                            <span class="sl-icon icon-bell"></span>
                            <div class="recent-activity-item-timestamp">
                                <p>{{$notification->created_at->format('d/m/y : h:i')}}</p>
                            </div>
                            <div class="recent-activity-item-info">
                                <p><span class="bold">{{$notification->title}} - </span> {{$notification->text}}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-bell"></span>
                        <div class="recent-activity-item-timestamp">
                            <p></p>
                        </div>
                        <div class="recent-activity-item-info">
                            <p><span class="bold">@lang('user_panel.no_activity')</span></p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="clearfix"></div>
        </div>


    </div>

@endsection