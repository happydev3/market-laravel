@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.store_wallet') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline statement primary">
            <h4>{{Auth::guard('store')->user()->business_name}} Wallet</h4>
            <button form="statement_filter_form" type="submit" class="button dark-light">@lang('store_panel.refine_search')</button>
            <form id="statement_filter_form" name="statement_filter_form" method="POST" action="{{route('store.wallet.date')}}" class="statement-form">
                {{csrf_field()}}
                <!-- DATEPICKER -->
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

        <!-- SALE DATA -->
        <div class="sale-data">
            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-present"></span>
                <p class="text-header big">{{$transactions_today}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.transactions_today')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->

            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-present"></span>
                <p class="text-header big">{{$transactions_month}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.transactions_month')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->

            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-tag"></span>
                <p class="price big"><span>€</span>{{number_format($full_import,2)}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.gross_income')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->

            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-wallet"></span>
                <p class="price big"><span>€</span>{{number_format($neto_import,2)}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.net_income')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->
        </div>
        <!-- /SALE DATA -->

        <!-- TRANSACTION LIST -->
        <div class="transaction-list">
            <!-- TRANSACTION LIST HEADER -->
            <div class="transaction-list-header">
                <div class="transaction-list-header-date">
                    <p class="text-header small">@lang('store_panel.wallet_table_data')</p>
                </div>
                <div class="transaction-list-header-author">
                    <p class="text-header small">@lang('store_panel.wallet_table_user')</p>
                </div>
                <div class="transaction-list-header-item">
                    <p class="text-header small">@lang('store_panel.wallet_table_qrcode')</p>
                </div>
                <div class="transaction-list-header-detail">
                    <p class="text-header small">@lang('store_panel.wallet_table_transaction')</p>
                </div>
                <div class="transaction-list-header-code">
                    <p class="text-header small">@lang('store_panel.wallet_table_import')</p>
                </div>
                <div class="transaction-list-header-price">
                    <p class="text-header small">@lang('store_panel.wallet_table_cashback')</p>
                </div>
                <div class="transaction-list-header-cut">
                    <p class="text-header small">@lang('store_panel.wallet_table_net')</p>
                </div>
                <div class="transaction-list-header-earnings">
                    <p class="text-header small">@lang('store_panel.wallet_table_status')</p>
                </div>
            </div>
            <!-- /TRANSACTION LIST HEADER -->

            @foreach($transactions as $transaction)
                <div class="transaction-list-item">
                    <div class="transaction-list-item-date">
                        <p>{{\Illuminate\Support\Carbon::parse($transaction->created_at)->format('d/m/20y - h:i')}}</p>
                    </div>
                    <div class="transaction-list-item-author">
                        <p class="text-header">{{$transaction->user->name}}</p>
                    </div>
                    <div class="transaction-list-item-item">
                        <p class="category primary">@if($transaction->qr_code != "" ) {{$transaction->qr_code}} @else @if($transaction->status == "accepted") @lang('store_panel.cash_transaction') @else @lang('store_panel.online_transaction')@endif @endif</p>
                    </div>
                    <div class="transaction-list-item-detail">
                        <p><span class="light">TR_{{$transaction->id}}</span></p>
                    </div>
                    <div class="transaction-list-item-code">
                        <p>{{ number_format($transaction->full_import,2) }}€</p>
                    </div>
                    <div class="transaction-list-item-price">
                        <p>{{ number_format($transaction->discount_rate,2) }}%</p>
                    </div>
                    <div class="transaction-list-item-cut">
                        <p><span class="light">{{ number_format($transaction->cashback_neto + $transaction->freeback_neto,2) }} €</span></p>
                    </div>
                    <div class="transaction-list-item-earnings">
                        <p class="text-header">@lang('store_panel.transaction_completed')</p>
                    </div>
                    <div class="transaction-list-item-icon">

                    </div>
                </div>
                <!-- /TRANSACTION LIST ITEM -->

            @endforeach
        </div>
        <!-- /TRANSACTION LIST -->
    </div>
    <!-- DASHBOARD CONTENT -->


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
