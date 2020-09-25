@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.user_wallet') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>{{Auth::user()->name}} Wallet</h4>
            <button form="statement_filter_form" type="submit" class="button dark-light">@lang('store_panel.refine_search')</button>
            <form id="statement_filter_form" action="{{route('user.wallet.filter')}}" method="POST" name="statement_filter_form" class="statement-form">
                <!-- DATEPICKER -->
                {{csrf_field()}}
                <div class="datepicker-wrap">
                    <input type="text" id="date_from" name="date_from" class="datepicker" value="01/01/{{\Carbon\Carbon::now()->year}}">
                    <span class="icon-calendar"></span>
                </div>
                <!-- /DATEPICKER -->
                <label>to:</label>
                <!-- DATEPICKER -->
                <div class="datepicker-wrap">
                    <input type="text" id="date_to" name="date_to" class="datepicker" value="{{\Carbon\Carbon::now()->format('d/m/20y')}}">
                    <span class="icon-calendar"></span>
                </div>
                <!-- /DATEPICKER -->
            </form>
        </div>
        <!-- /HEADLINE -->

        <!-- GRAPH STATS LIST -->
        <div class="graph-stats-list">
            <!-- GRAPH STATS LIST ITEM -->
            <div class="graph-stats-list-item green bars">
                <h2>{{number_format($todayAmount,2)}}€</h2>
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

        <!-- TRANSACTION LIST -->
        <div class="transaction-list">
            <!-- TRANSACTION LIST HEADER -->
            <div class="transaction-list-header">
                <div class="transaction-list-header-date">
                    <p class="text-header small">@lang('user_panel.wallet_table_date')</p>
                </div>
                <div class="transaction-list-header-author">
                    <p class="text-header small">@lang('user_panel.wallet_table_store')</p>
                </div>
                <div class="transaction-list-header-item">
                    <p class="text-header small">@lang('user_panel.wallet_table_order')</p>
                </div>
                <div class="transaction-list-header-detail">
                    <p class="text-header small">@lang('user_panel.wallet_table_type')</p>
                </div>
                <div class="transaction-list-header-code">
                    <p class="text-header small">@lang('user_panel.wallet_table_transaction')</p>
                </div>
                <div class="transaction-list-header-price">
                    <p class="text-header small">@lang('user_panel.wallet_table_price')</p>
                </div>
                <div class="transaction-list-header-cut">
                    <p class="text-header small">@lang('user_panel.wallet_table_cashback')</p>
                </div>
                <div class="transaction-list-header-earnings">
                    <p class="text-header small">@lang('user_panel.wallet_table_earnings')</p>
                </div>
            </div>
            <!-- /TRANSACTION LIST HEADER -->

            @foreach($transactions as $transaction)
                @if($transaction["type"] == "td")
                    <div class="transaction-list-item">
                        <div class="transaction-list-item-date">
                            <p>{{\Illuminate\Support\Carbon::parse($transaction["created_at"])->format("d/m/20y - h:i")}}</p>
                        </div>
                        <div class="transaction-list-item-author">
                            <p class="text-header">{{$transaction["business_name"]}}</p>
                        </div>
                        <div class="transaction-list-item-item">
                            <p class="category primary">Online</p>
                        </div>
                        <div class="transaction-list-item-detail">
                            <p>@lang('user_panel.purchase')</p>
                        </div>
                        <div class="transaction-list-item-code">
                            <p><span class="light">TR_00{{$transaction["id"]}}</span></p>
                        </div>
                        <div class="transaction-list-item-price">
                            <p>{{number_format($transaction["full_import"],2)}}€</p>
                        </div>
                        <div class="transaction-list-item-cut">
                            <p><span class="light">{{number_format($transaction["effective_cashback"],2)}}%</span></p>
                        </div>
                        <div class="transaction-list-item-earnings">
                            <p class="text-header">{{number_format($transaction["cashback_neto"],2)}}€</p>
                        </div>
                        <div class="transaction-list-item-icon">
                            <div class="transaction-icon primary">
                                <!-- SVG PLUS -->
                                <svg class="svg-plus">
                                    <use xlink:href="#svg-plus"></use>
                                </svg>
                                <!-- /SVG PLUS -->
                            </div>
                        </div>
                    </div>
                @else
                    <div class="transaction-list-item">
                        <div class="transaction-list-item-date">
                            <p>{{\Illuminate\Support\Carbon::parse($transaction->created_at)->format("d/m/20y - h:i")}}</p>
                        </div>
                        <div class="transaction-list-item-author">
                            <p class="text-header"><a target="_blank" href="{{route('marketplace.store_landing',['id'=>$transaction->store->permalink])}}">{{$transaction->store->first()->business_name}}</a></p>
                        </div>
                        <div class="transaction-list-item-item">
                            <p class="category primary">@if($transaction->order_id != null)ORD_{{$transaction->order_id}}@else @lang('pages_text.offline_vendor_desc')@endif</p>
                        </div>
                        <div class="transaction-list-item-detail">
                            <p>@lang('user_panel.purchase')</p>
                        </div>
                        <div class="transaction-list-item-code">
                            <p><span class="light">TR_00{{$transaction->id}}</span></p>
                        </div>
                        <div class="transaction-list-item-price">
                            <p>{{number_format($transaction->full_import,2)}}€</p>
                        </div>
                        <div class="transaction-list-item-cut">
                            <p><span class="light">{{number_format($transaction->store->effectiveCashback(),2)}}%</span></p>
                        </div>
                        <div class="transaction-list-item-earnings">
                            <p class="text-header">{{number_format($transaction->cashback_neto,2)}}€</p>
                        </div>
                        <div class="transaction-list-item-icon">
                            <div class="transaction-icon primary">
                                <!-- SVG PLUS -->
                                <svg class="svg-plus">
                                    <use xlink:href="#svg-plus"></use>
                                </svg>
                                <!-- /SVG PLUS -->
                            </div>
                        </div>
                    </div>
                    <!-- /TRANSACTION LIST ITEM -->
                @endif
            @endforeach
        </div>
    </div>
    <!-- /TRANSACTION LIST -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::to('js/vendor/bootstrap-datepicker.it.min.js')}}"></script>
    <script>
        (function($){
            $('.datepicker').datepicker({
                'language': '{{App::getLocale()}}',
                'format' : 'dd/mm/yyyy',
            });
        })(jQuery);
    </script>
@endsection