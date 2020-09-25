@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_order_details') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('admin-res/vendor/datatables/dataTables.bs4.css')}}" />
    <link rel="stylesheet" href="{{URL::to('admin-res/vendor/datatables/dataTables.bs4-custom.css')}}" />
@endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-shopping-cart2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.order_details_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.order_details_subheading') {{$order->id}}</h6>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="right-actions">
                        <span class="last-login">@lang('admin.stores_update') {{\Illuminate\Support\Carbon::now()->format('d/m/y-h:i')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">

        <div class="row gutters">
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.order_details_heading')</div>
                    <div class="card-body">
                        <h6 class="card-text">@lang('admin.orders_table_date'): {{$order->created_at->format('d/m/20y - h:i')}}</h6>
                        <h6 class="card-text">@lang('admin.order_table_status'): {{$order->status }}</h6>
                        <h6 class="card-text">@lang('admin.order_table_courier'): {{$order->courier }}</h6>
                        <h6 class="card-text">@lang('admin.order_table_tracking_no'): {{$order->tracking_no }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.store_details')</div>
                    <div class="card-body">
                        <h6 class="card-text">@lang('admin.store_business_name'): {{$order->created_at->format('d/m/20y - h:i')}}</h6>
                        <h6 class="card-text">@lang('admin.store_address'): {{$order->store->street_address }}</h6>
                        <h6 class="card-text">@lang('admin.store_email'): {{$order->store->email }}</h6>
                        <h6 class="card-text">@lang('admin.store_discount'): {{number_format($order->store->discount_rate,2) }}%</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.user_details')</div>
                    <div class="card-body">
                        <h6 class="card-text">@lang('admin.users_table_name'): {{$order->user->name}}</h6>
                        <h6 class="card-text">@lang('admin.shipping_to'): {{$order->shipping_address->name}}</h6>
                        <h6 class="card-text">@lang('admin.shipping_address'): {{$order->shipping_address->address}}, {{ $order->shipping_address->house_number }}</h6>
                        <h6 class="card-text">@lang('admin.shipping_city'): {{$order->shipping_address->city}}</h6>
                        <h6 clasS="card-text">@lang('admin.users_table_email') {{ $order->user->email }}</h6>
                        <h6 class="card-text">@lang('admin.users_table_phone'): {{$order->user->phone_no}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.transaction_details')</div>
                    <div class="card-body">
                        <h6 class="card-text">@lang('admin.transaction_table_id'): TR_{{$order->online_transaction->id}}</h6>
                        <h6 class="card-text">@lang('admin.transaction_table_import'): {{number_format($order->online_transaction->full_import,2)}}€</h6>
                        <h6 class="card-text">Cashback: {{number_format($order->online_transaction->cashback,2)}}€</h6>
                        <h6 class="card-text">@lang('admin.transaction_table_store_neto'): {{ number_format($order->online_transaction->neto_import,2)}}€</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.order_content')</div>
                    <div class="card-body">
                        <table id="productsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.products_table_img')</th>
                                <th>@lang('admin.products_table_id')</th>
                                <th>@lang('admin.products_online_title')</th>
                                <th>@lang('admin.products_table_price')</th>
                                <th>@lang('admin.products_table_quantity')</th>
                                <th>@lang('admin.users_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($order->disputed)
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">@lang('admin.dispute_panel_title')</div>
                        <div class="card-body">
                            <p>@lang('admin.dispute_opened_at') {{$dispute->created_at->format('d/m/20y')}}</p>
                            <p>@lang('admin.dispute_message') {{$dispute->problem_description}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $('#productsTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_order_products',['id'=>$order->id])}}","dataSrc":""},
            "columns" : [
                {
                    "data": "multimedia[0].url",
                    "render": function (data) {
                        return "<img height='100px' width='160px' src=\"https://www.freeback.it/" + data + "\">";
                    }
                },
                {"data" : "id"},
                {"data" : "title"},
                {
                    "data" : "price",
                    "render" : function(data){
                        return data + "€";
                    }
                },
                {
                    "data": "product_quantity"
                },
                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="link/' + data + '\" class="btn btn-success" target=\'_blank\'> @lang('admin.visit_product') </a>';
                        return btn;
                    }
                }
            ]
        });
    </script>
@endsection