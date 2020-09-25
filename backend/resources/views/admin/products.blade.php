@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_products') @endsection

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
                        <i class="icon-gift2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.products_page_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.products_page_subheading'){{$productsCount}}</h6>
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
                    <div class="card-header">@lang('admin.products_table_title')</div>
                    <div class="card-body">
                        <table id="productsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.products_table_img')</th>
                                <th>@lang('admin.products_table_id')</th>
                                <th>@lang('admin.products_online_title')</th>
                                <th>@lang('admin.products_table_seller')</th>
                                <th>@lang('admin.products_table_price')</th>
                                <th>@lang('admin.products_table_quantity')</th>
                                <th>@lang('admin.products_table_status')</th>
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
    </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $('#productsTable').DataTable({
            "ajax": {"url": " {{route('admin.ajax_products')}}", "dataSrc": ""},
            "columns": [
                {
                    "data": "multimedia[0].url",
                    "render": function (data) {
                        return "<img height='100px' width='160px' src=\"https://www.freebacak.it/" + data + "\">";
                    }
                },
                {"data": "id"},
                {"data": "title"},
                {"data":"store.business_name"},
                {
                    "data": "price",
                    "render": function (data) {
                        return data + "€";
                    }
                },
                {"data": "quantity_available"},
                {
                    "data": "active",
                    "render": function (data) {
                        if (data == 0)
                            return "<span class=\"badge badge-primary\">@lang('admin.status_unavailable')</span>";
                        else
                            return "<span class=\"badge badge-success\">@lang('admin.statis_available')</span>";
                    }
                },
                {
                    "data": "id",
                    "render": function (data) {
                        //TODO Connect the Correct Product Route Here
                        return "<a href=\"#\" class=\"btn btn-success btn-sm\" target=\"_blank\">" + "@lang('admin.visit_product')</a>";
                    }
                }
            ]
        });
    </script>
@endsection