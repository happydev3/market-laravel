@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.manage_orders') @endsection

@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline purchases primary">
            <h4>@lang('store_panel.orders_page_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- PURCHASES LIST -->
        <div class="purchases-list">
            <!-- PURCHASES LIST HEADER -->
            <div class="purchases-list-header">
                <div class="purchases-list-header-date">
                    <p class="text-header small">@lang('store_panel.orders_table_date')</p>
                </div>
                <div class="purchases-list-header-details">
                    <p class="text-header small">@lang('store_panel.orders_table_product')</p>
                </div>
                <div class="purchases-list-header-info">
                    <p class="text-header small">@lang('store_panel.orders_table_to')</p>
                </div>
                <div class="purchases-list-header-price">
                    <p class="text-header small">@lang('store_panel.orders_table_price')</p>
                </div>
                <div class="purchases-list-header-download">
                    <p class="text-header small">@lang('store_panel.orders_table_status')</p>
                </div>
                <div class="purchases-list-header-recommend">
                    <p class="text-header small">@lang('store_panel.orders_table_actions')</p>
                </div>
            </div>
            <!-- /PURCHASES LIST HEADER -->


            @foreach($orders as $order)
                <!-- PURCHASE ITEM -->
                    <div class="purchase-item">
                        <div class="purchase-item-date">
                            <p>{{$order->created_at->format('d/m/20y')}}</p>
                        </div>
                        <div class="purchase-item-details">
                            <!-- ITEM PREVIEW -->
                            <div class="item-preview">
                                <figure class="product-preview-image small liquid">
                                 @if($order->product->first()->multimedia->where('type','web_thumb')->count() > 0 )
                                        <img src="{{URL::to($order->product->first()->multimedia->where('type','web_thumb')->first()->url)}}">
                                 @else
                                        <img src="{{URL::to('images/items/no-photo-item.png')}}">
                                 @endif

                                </figure>
                                <p class="text-header">{{$order->product->first()->title}}</p>
                                <p class="description">@lang('store_panel.product_quantity') : {{$order->product_quantity}}</p>
                            </div>
                            <!-- /ITEM PREVIEW -->
                        </div>
                        <div class="purchase-item-info">
                            <p class="category primary">{{\App\Models\OrderShippingAddress::where('id',$order->order_shipping_addresses_id)->first()->name}}</p>
                            <p>{{\App\Models\OrderShippingAddress::where('id',$order->order_shipping_addresses_id)->first()->address}},n {{\App\Models\OrderShippingAddress::where('id',$order->order_shipping_addresses_id)->first()->house_number}}</p>
                            <p>{{\App\Models\OrderShippingAddress::where('id',$order->order_shipping_addresses_id)->first()->city}}</p>
                            <p class="text-header tiny">{{\App\Models\OrderShippingAddress::where('id',$order->order_shipping_addresses_id)->first()->zip_code}}</p>
                        </div>
                        <div class="purchase-item-price">
                            <p class="price"><span>€</span>{{number_format($order->online_transaction->full_import,2)}}</p>
                        </div>
                        <div class="purchase-item-download">
                            @if($order->status == 'recieved')
                                <p align="center">@lang('store_panel.order_not_processed')</p>
                            @else
                                <p align="center">@lang('store_panel.order_processed')</p>
                            @endif
                        </div>
                        <div class="purchase-item-recommend">
                            @if($order->status == 'recieved')
                                <p align="center"><a href="{{route('store.order.manage',['order_id' => $order->id])}}" class="button dark-light">@lang('store_panel.process_order')</a></p>
                            @else
                                <p align="center"><a href="{{route('store.order_details',['order_id' => $order->id])}}" class="button dark-light">@lang('store_panel.order_details_btn')</a></p>
                            @endif
                        </div>
                    </div>
                    <!-- /PURCHASE ITEM -->
            @endforeach

            <!-- PAGER -->
            <div class="pager-wrap">
                {{$orders->links()}}
            </div>
            <!-- /PAGER -->
        </div>
        <!-- /PURCHASES LIST -->
    </div>
    <!-- DASHBOARD CONTENT -->
    </div>
    <!-- /DASHBOARD BODY -->

@endsection

