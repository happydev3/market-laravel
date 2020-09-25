@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.user_orders') @endsection
@section('custom_css')  <link rel="stylesheet" href="{{URL::to('css/vendor/magnific-popup.css')}}"> @endsection


@section('page_content')

    @include('user.components.positive_review')
    @include('user.components.negative_review')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline purchases primary">
            <h4>@lang('user_panel.orders_page_title') ({{$ordersCount}}) </h4>
        </div>
        <!-- /HEADLINE -->

        <!-- PURCHASES LIST -->
        <div class="purchases-list">
            <!-- PURCHASES LIST HEADER -->
            <div class="purchases-list-header">
                <div class="purchases-list-header-date">
                    <p class="text-header small">@lang('user_panel.your_orders_table_date')</p>
                </div>
                <div class="purchases-list-header-details">
                    <p class="text-header small">@lang('user_panel.your_orders_table_product')</p>
                </div>
                <div class="purchases-list-header-info">
                    <p class="text-header small">@lang('user_panel.your_orders_table_vendor')</p>
                </div>
                <div class="purchases-list-header-price">
                    <p class="text-header small">@lang('user_panel.your_orders_table_import')</p>
                </div>
                <div class="purchases-list-header-download">
                    <p class="text-header small">@lang('user_panel.your_orders_table_dispute')</p>
                </div>
                <div class="purchases-list-header-recommend">
                    <p class="text-header small">@lang('user_panel.your_orders_table_review')</p>
                </div>
            </div>
            <!-- /PURCHASES LIST HEADER -->


            @foreach($orders as $order)
                <div class="purchase-item">
                    <div class="purchase-item-date">
                        <p>{{$order->created_at->format('d/m/20y')}}</p>
                    </div>
                    <div class="purchase-item-details">
                        <!-- ITEM PREVIEW -->
                        <div class="item-preview">
                            <figure class="product-preview-image small liquid">
                                 @if($order->product->multimedia->where('type','web_thumb') != null)
                                    <img src="{{URL::to($order->product->multimedia->where('type','web_thumb')->first()->url )}}" alt="product-image">
                                 @else
                                     <img src="{{URL::to('images/items/no-photo-item.png')}}">
                                 @endif
                            </figure>
                            <p class="text-header">{{$order->product->title}}</p>
                            <p class="description">{{substr($order->product->description,0,14)}}...</p>
                        </div>
                        <!-- /ITEM PREVIEW -->
                    </div>
                    <div class="purchase-item-info">
                        <p class="category primary">{{$order->store->business_name}}</p>
                        <p><span class="light">@lang('user_panel.shipped'):</span> {{$order->courier}}</p>
                        @if($order->tracking_no != "")<p><span class="light">@lang('store_panel.tracking_code'): {{$order->tracking_no}}</span></p> @endif
                    </div>
                    <div class="purchase-item-price">
                        <p class="price"><span>€</span>{{$order->online_transaction->full_import}}</p>
                    </div>
                    <div class="purchase-item-download">
                        @if($order->disputed)
                            <p class="button" style="color:grey">@lang('user_panel.dispute_sent')</p>
                        @else
                            @if(\Carbon\Carbon::now() <= $order->disputable_until)
                                <a href="{{route('user.dispute_open',['orderId'=>$order->id])}}" class="button dark-light">@lang('user_panel.open_dispute_btn')</a>
                            @else
                                <p class="button" style="color:grey">@lang('user_panel.time_expired')</p>
                            @endif
                        @endif
                    </div>
                    @if($order->reviewed)
                        <div class="purchase-item-download">
                            <a href="#" class="button primary">@lang('user_panel.review_sent')</a>
                        </div>
                    @else
                        <div class="purchase-item-recommend">
                            <div class="recommendation-wrap">
                                <a href="#positive-recommendation-popup"  data-order="{{$order->id}}" class="recommendation good hoverable open-recommendation-form">
                                    <span class="icon-like"></span>
                                </a>
                                <a href="#negative-recommendation-popup" data-order="{{$order->id}}" class="recommendation bad hoverable open-recommendation-form">
                                    <span class="icon-dislike"></span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /PURCHASE ITEM -->
            @endforeach
            <!-- PAGER -->
                {{$orders->links()}}
            <!-- /PAGER -->
        </div>
        <!-- /PURCHASES LIST -->
    </div>
    <!-- DASHBOARD CONTENT -->



@endsection


@section('custom_js')
    <script src="{{URL::to('js/vendor/imgLiquid-min.js')}}"></script>
    <script src="{{URL::to('js/vendor/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{URL::to('js/liquid.js')}}"></script>
    <script src="{{URL::to('js/dashboard-purchases.js')}}"></script>
    <script src="{{URL::to('js/reviews.js')}}"></script>
@endsection