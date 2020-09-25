@extends('user.layouts.dashboard_layout')

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
                    <p class="text-header small">@lang('user_panel.wallet_table_date')</p>
                </div>
                <div class="transaction-list-header-author">
                    <p class="text-header small">@lang('user_panel.wallet_table_store')</p>
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
                        <p><span class="light">{{number_format($transaction->store->discount_rate,2)}}%</span></p>
                    </div>
                    <div class="transaction-list-item-earnings">
                        <p class="text-header">{{number_format($transaction->full_import - $transaction->neto_import,2)}}€</p>
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
