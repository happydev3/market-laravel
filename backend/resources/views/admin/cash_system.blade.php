@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.cash_system_title') @endsection

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
                        <i class="icon-tabs-outline"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.cash_system_panel_title')</h5>
                        <h6 class="sub-heading">@lang('admin.cash_system_panel_subtitle')</h6>
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
                    <div class="card-header">@lang('admin.cash_system_store_title') - (@lang('admin.cash_system_import') {{ number_format($totalImport,2) }}€)</div>
                    <div class="card-body">
                        <table id="storesTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.store_business_name')</th>
                                <th>@lang('admin.store_email')</th>
                                <th>@lang('admin.store_discount')</th>
                                <th>@lang('admin.transaction_table_import')</th>
                                <th>Cashback</th>
                                <th>Freeback</th>
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
        $('#storesTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_cash_status')}}","dataSrc":""},
            "columns" : [
                {
                    "data" : "business_name",
                },
                {"data" : "email"},
                {
                    "data" : "discount_rate",
                    "render" : function (data) {
                        return data + "%";
                    }

                },
                {
                    "data" : "full_import",
                    "render" : function(data){
                        return data + "€";
                    }
                },

                {
                    "data" : "cashback",
                    "render" : function(data){
                        return data + "€";
                    }
                },

                {
                    "data" : "freeback",
                    "render" : function(data){
                        return data + "€";
                    }
                },
            ]
        });
    </script>
@endsection