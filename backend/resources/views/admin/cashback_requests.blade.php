@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.cashback_requests') @endsection

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
                        <i class="icon-list"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.cashbacks_request_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.cashback_requests_subheading')</h6>
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
                    <div class="card-header">@lang('admin.cashback_requests_side')</div>
                    <div class="card-body">
                        <table id="transactionsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_date')</th>
                                <th>@lang('admin.transaction_table_user')</th>
                                <th>@lang('admin.transaction_table_import')</th>
                                <th>@lang('admin.order_table_status')</th>
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
        var transactionTable = $('#transactionsTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax.cashback_requests')}}","dataSrc":""},
            "columns" : [
                {"data" : "created_at"},
                {"data" : "user.name"},
                {
                    "data" : "import",
                    "render" : function(data){
                        var improt = Number(data);
                        return improt.toFixed(2) + "€";
                    }
                },
                {
                    "data" : "status",
                    "render" : function(data){
                        if(data == "accepted"){
                            return "<span class=\"badge badge-primary\">@lang('admin.request_cashback_status_accepted')</span>";
                        }
                        else {
                            return "<span class=\"badge badge-success\">@lang('admin.request_cashback_status_sent')</span>";
                        }
                    }
                },
                {
                    "data" : "id",
                    "render" : function(data,type,row){
                        var btn = '<a href="cashback_request/details/' + data + '\" class="btn btn-warning"> @lang('admin.table_details')</a>';
                        return btn;                    }
                },
            ]
        });

    </script>
@endsection