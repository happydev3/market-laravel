@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_orders') @endsection

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
                        <h5>@lang('admin.orders_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.orders_subheading') {{ $ordersCount }}</h6>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.orders_panel_title')</div>
                    <div class="card-body">
                        <table id="ordersTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.orders_table_id')</th>
                                <th>@lang('admin.orders_table_date')</th>
                                <th>@lang('admin.orders_table_user')</th>
                                <th>@lang('admin.orders_table_store')</th>
                                <th>@lang('admin.order_table_status')</th>
                                <th>@lang('admin.order_table_courier')</th>
                                <th>@lang('admin.order_table_tracking_no')</th>
                                <th>@lang('admin.order_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $('#ordersTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_orders')}}","dataSrc":""},
            "columns" : [
                {"data" : "id"},
                {"data" : "created_at"},
                {"data" : "user.name"},
                {"data" : "store.business_name"},
                {
                    "data" : "status",
                    "render" : function(data){
                        var result = "";
                        switch (data) {
                            case "recieved" :
                                result = "<span class=\"badge badge-secondary\">@lang('admin.order_recieved')</span>";
                                break;
                            case "sent":
                                result = "<span class=\"badge badge-info\">@lang('admin.order_sent')</span>";
                                break;
                            case "delivered":
                                result = "<span class=\"badge badge-success\">@lang('admin.order_delivered')</span>";
                                break;
                        }
                        return result;
                    }
                },
                {
                    "data" : "courier",
                    "render" : function(data){
                        if(data == "NO"){
                            return "<span class=\"badge badge-secondary\">@lang('admin.courier_not_selected')</span>";
                        }
                        else {
                            return data;
                        }
                    }
                },
                {
                    "data" : "tracking_no",
                    "render" : function(data){
                        if(data == null){
                            return "<span class=\"badge badge-secondary\">@lang('admin.tracking_not_provided')</span>";
                        }
                        else {
                            return data;
                        }
                    }
                },
                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="order/details/' + data + '\" class="btn btn-success"> @lang('admin.order_details_action') </a>';
                        return btn;
                    }
                }
            ]
        });
    </script>
@endsection