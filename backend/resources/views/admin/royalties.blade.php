@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.royalties_title') @endsection

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
                        <h5>@lang('admin.royalties_panel_title')</h5>
                        <h6 class="sub-heading">@lang('admin.total_sum'){{number_format($totalRoyaltiesGetter + $totalStoresRoyalties,2)}}€</h6>
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
                    <div class="card-header">@lang('admin.getter_royalties') ( {{number_format($totalRoyaltiesGetter,2)}}€)</div>
                    <div class="card-body">
                        <table id="gettersTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.getter_table_name')</th>
                                <th>@lang('admin.getter_table_mail')</th>
                                <th>IBAN</th>
                                <th>@lang('admin.total_sum')</th>
                                <th>@lang('admin.products_table_status')</th>
                                <th>@lang('admin.getter_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.store_royalties') ( {{number_format($totalStoresRoyalties,2)}}€)</div>
                    <div class="card-body">
                        <table id="storesTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.store_business_name')</th>
                                <th>@lang('admin.getter_table_mail')</th>
                                <th>@lang('admin.total_sum')</th>
                                <th>@lang('admin.products_table_status')</th>
                                <th>@lang('admin.getter_table_actions')</th>
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
        $('#gettersTable').DataTable({
            "ajax": {"url": " {{route('admin.ajax.getters_royalties')}}", "dataSrc": ""},
            "columns": [
                {
                    "data": "name",
                },
                {"data": "email"},
                {"data": "iban"},
                {
                    "data":"fees_sum",
                    "render" : function(data){
                        return data + "€";
                    }
                },
                {
                    "data": "id",
                    "render": function (data) {
                        return "<span class=\"badge badge-primary\">@lang('admin.getter_payment_status')</span>";

                    }
                },
                {
                    "data": "id",
                    "render": function (data) {
                        return "<a href=\"royalties/getters/paid\/"+ data + "\" class=\"btn btn-success btn-sm\">" + "@lang('admin.getter_mark_paid')</a>";
                    }
                }
            ]
        });


        $('#storesTable').DataTable({
            "ajax": {"url": " {{route('admin.ajax_store_royalties')}}", "dataSrc": ""},
            "columns": [
                {
                    "data": "business_name",
                },
                {"data": "email"},
                {
                    "data":"import",
                    "render" : function(data){
                       return data + "€";
                    }
                },
                {
                    "data": "id",
                    "render": function (data) {
                        return "<span class=\"badge badge-primary\">@lang('admin.getter_payment_status')</span>";

                    }
                },
                {
                    "data": "id",
                    "render": function (data) {
                        return "<a href=\"royalties/stores/paid\/"+ data + "\" class=\"btn btn-success btn-sm\">" + "@lang('admin.getter_mark_paid')</a>";
                    }
                }
            ]
        });



    </script>
@endsection