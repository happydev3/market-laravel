@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.single_order_manage')  @endsection

@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.order_details_panel_title') {{ $order->id }}</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item">
                <h4>@lang('store_panel.product_info')</h4>
                    <hr class="line-separator">
                    <img class="img-responsive" src="{{ URL::to($order->product->first()->multimedia->where('type','web_thumb')->first()->url)}}">
                    <hr class="line-separator">
                    <label class="rl-label">@lang('store_panel.product_title') : {{$order->product->title}}</label>
                    <label class="rl-label">@lang('store_panel.product_qta') : {{$order->product_quantity}}</label>
                    <label class="rl-label">@lang('store_panel.order_date') : {{$order->created_at->format('d/m/20y')}}</label>
                    <label class="rl-label">@lang('store_panel.order_import') : {{number_format($order->online_transaction->full_import,2)}}€</label>
                    <label class="rl-label">Cashback : {{number_format($order->online_transaction->full_import * ($order->online_transaction->discount_rate/100),2)}}€</label>
                    <label class="rl-label">@lang('store_panel.courier') : {{$order->courier}}</label>
                    <label class="rl-label">@lang('store_panel.tracking_code') : {{$order->tracking_no}}</label>
                    <hr class="line-separator">
            </div>
            <!-- /FORM BOX ITEM -->

            <!-- FORM BOX ITEM -->
            <div class="form-box-item withdraw-history">
                <h4>@lang('store_panel.shipping_info')</h4>
                <hr class="line-separator">
                <!-- TRANSACTION HISTORY -->
                <div class="transaction-history">
                    <!-- TRANSACTION HISTORY ITEM -->
                    <div class="transaction-history-item">
                        <div class="transaction-history-item-date">
                            <p>@lang('user_panel.update_address_name'): </p>
                        </div>
                        <div class="transaction-history-item-mail">
                            <p>{{$shipping_address->name}}</p>
                        </div>
                    </div>

                    <div class="transaction-history-item">
                        <div class="transaction-history-item-date">
                            <p>@lang('user_panel.full_address'): </p>
                        </div>
                        <div class="transaction-history-item-mail">
                            <p>{{$shipping_address->address ." ". $shipping_address->house_number  }}</p>
                        </div>
                    </div>
                    <!-- /TRANSACTION HISTORY ITEM -->

                    <div class="transaction-history-item">
                        <div class="transaction-history-item-date">
                            <p>@lang('user_panel.city'): </p>
                        </div>
                        <div class="transaction-history-item-mail">
                            <p>{{$shipping_address->city  }}</p>
                        </div>
                    </div>

                    <div class="transaction-history-item">
                        <div class="transaction-history-item-date">
                            <p>@lang('user_panel.zip_code'): </p>
                        </div>
                        <div class="transaction-history-item-mail">
                            <p>{{$shipping_address->zip_code  }}</p>
                        </div>
                    </div>

                    <div class="transaction-history-item">
                        <div class="transaction-history-item-date">
                            <p>@lang('user_panel.additional_notes'):  </p>
                        </div>
                        <div class="transaction-history-item-mail">
                            <p>{{$shipping_address->additional_notes }}</p>
                        </div>
                    </div>

                    <p>@lang('user_panel.invoice_details'):
                        @if ($shipping_address->invoice_same_address)
                            @lang('pages_text.invoice_same_address')
                        @else
                            {{$shipping_address->invoice_details }}
                        @endif
                    </p>

                </div>

            </div>
            <!-- /TRANSACTION HISTORY -->
        </div>
        <!-- /FORM BOX ITEM -->
    </div>
    <!-- /FORM BOX ITEMS -->
    </div>
    <!-- DASHBOARD CONTENT -->

@endsection