@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.user_wallet') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('user_panel.transactions_from') {{$dateFrom->format('d/m/20y')}} @lang('user_panel.transactions_to') {{$dateTo->format('d/m/20y')}} </h4>
        </div>
        <!-- /HEADLINE -->
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
                        <p>{{ number_format($transaction->store->discount_rate,2) }}%</p>
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
    <!-- /TRANSACTION LIST -->
@endsection