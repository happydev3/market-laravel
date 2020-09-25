@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.cash_invoices_title') @endsection

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
                        <h5>@lang('admin.invoices_page_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.invoices_subheading')</h6>
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
                    <div class="card-header">@lang('admin.invoices') - (@lang('admin.invoiced') {{ number_format($invoiceSum,2) }}€)</div>
                    <div class="card-body">
                        <table id="cashInvoicesTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.invoice_table_no')</th>
                                <th>@lang('admin.invoice_table_date')</th>
                                <th>@lang('admin.invoice_table_to')</th>
                                <th>@lang('admin.invoice_table_import')</th>
                                <th>Cashback</th>
                                <th>Freeback</th>
                                <th>@lang('admin.payment_status')</th>
                                <th>@lang('admin.sending_status')</th>
                                <th>@lang('admin.td_store_discounts_table_actions')</th>
                                <th>@lang('admin.invoice_table_download')</th>
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
        $('#cashInvoicesTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_cash_invoices')}}","dataSrc":""},
            "columns" : [
                {
                    "data" : "invoice_number",
                    "render" : function(data){
                        return "WEB_" + data;
                    }
                },
                {"data" : "date"},
                {"data" : "store.business_name"},
                {
                    "data" : "total",
                    "render" : function(data){
                        return data + "€";
                    }
                },
                {
                    "data" : "cashback_fee",
                    "render" : function (data) {
                        return data + "€";
                    }
                },
                {
                    "data" : "freeback_fee",
                    "render" : function (data) {
                        return data + "€";
                    }
                },
                {
                    "data" : "paid",
                    "render" : function(data){
                        if(data == 1) {
                            return "<span class=\"badge badge-success\">@lang('admin.payment_status_paid')</span>";
                        } else {
                            return "<span class=\"badge badge-primary\">@lang('admin.payment_status_missing')</span>";
                        }
                    }
                },
                {
                    "data" : "sent",
                    "render" : function(data){
                        if(data == 1) {
                            return "<span class=\"badge badge-success\">@lang('admin.invoice_sent')</span>";
                        } else {
                            return "<span class=\"badge badge-primary\">@lang('admin.invoice_to_send')</span>";
                        }
                    }
                },

                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="cash/invoices/paymentmark/' + data + '\" class="btn btn-success"> @lang('admin.payment_status_mark_paid') </a>';
                        return btn;
                    }
                },
                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="cash/invoices/download/' + data + '\" class="btn btn-success"> PDF </a>';
                        var btn1 = ' <a href="cash/invoices/xml/download/' + data + '\" class="btn btn-success">  XML </a>';
                        var btn2 = ' <a href="cash/invoices/marksent/' + data + '\" class="btn btn-success">  @lang('admin.invoice_mark_sent') </a>';

                        return btn + btn1 + btn2;
                    }
                }
            ]
        });
    </script>
@endsection