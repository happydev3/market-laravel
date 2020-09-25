@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.approve_cash_transactions') @endsection

@section('page_content')
    <div class="dashboard-content">

        <div class="headline purchases primary">
            <h4>@lang('store_panel.cash_transactions_panel_title')</h4>
        </div>

        <div class="purchases-list">
            <div class="purchases-list-header">
                <div class="purchases-list-header-date">
                    <p class="text-header small">@lang('store_panel.cash_transaction_date')</p>
                </div>
                <div class="purchases-list-header-details">
                    <p class="text-header small">@lang('store_panel.user_details')</p>
                </div>
                <div class="purchases-list-header-info">
                    <p class="text-header small">@lang('store_panel.branch_details')</p>
                </div>
                <div class="purchases-list-header-price">
                    <p class="text-header small">@lang('store_panel.import')</p>
                </div>
                <div class="purchases-list-header-download">
                    <p class="text-header small">@lang('store_panel.status')</p>
                </div>
                <div class="purchases-list-header-recommend">
                    <p class="text-header small">@lang('store_panel.confirmation')</p>
                </div>
            </div>


            @foreach($transactions as $t)
                <div class="purchase-item">
                    <div class="purchase-item-date">
                        <p>{{$t->created_at->format('d/m/20y')}}</p>
                    </div>
                    <div class="purchase-item-details">
                        <!-- ITEM PREVIEW -->
                        <div class="item-preview">
                            <figure class="product-preview-image small liquid">
                                <img src="{{URL::to($t->user->userAvatarLink())}}" alt="product-image">
                            </figure>
                            <p class="text-header">{{$t->user->name}}</p>
                            <p class="description">@lang('store_panel.std_user') {{$t->user->created_at->format('d/m/20y')}}</p>
                        </div>
                        <!-- /ITEM PREVIEW -->
                    </div>
                    <div class="purchase-item-info">
                        <p class="category primary">{{$t->store->business_name}}</p>
                        <p><span class="light">@lang('store_panel.branch'):</span> {{$t->branch->street_address}}</p>
                        <p><span class="light">@lang('store_panel.cash_desk'):</span> {{$t->cashDesk->desk_name}}</p>
                    </div>
                    <div class="purchase-item-price">
                        <p class="price"><span>€</span>{{number_format($t->full_import,2)}}</p>
                    </div>
                    <div class="purchase-item-download">
                        <p class="button dark-light">
                            @lang('store_panel.status_to_confirm')
                        </p>
                    </div>
                    <div class="purchase-item-recommend">
                        <div class="recommendation-wrap">
                            <a href="{{route('store.cash_transaction.confirm',['id' => $t->id])}}" class="recommendation good hoverable">
                                <span class="icon-like"></span>
                            </a>
                            <a href="{{route('store.cash_transaction.decline',['id' => $t->id])}}" class="recommendation bad hoverable">
                                <span class="icon-dislike"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection