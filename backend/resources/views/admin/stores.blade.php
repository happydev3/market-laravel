@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_stores_title') @endsection

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
                        <i class="icon-shop2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.stores_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.stores_subheading')</h6>
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
                    <div class="card-header">@lang('admin.stores_table_title')</div>
                    <div class="card-body">
                        <table id="storesTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.store_business_name')</th>
                                <th>@lang('admin.store_email')</th>
                                <th>@lang('admin.store_discount')</th>
                                <th>@lang('admin.store_fb_fee')</th>
                                <th>@lang('admin.store_type')</th>
                                <th>@lang('admin.item_created_at')</th>
                                <th>@lang('admin.item_referral')</th>
                                <th>@lang('admin.item_invited_by')</th>
                                <th>@lang('admin.store_action')</th>
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
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

    <script>
        $('#storesTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_stores')}}","dataSrc":""},
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columns" : [
                {"data" : "business_name"},
                {"data" : "email"},
                {
                    "data" : "discount_rate",
                    "render" : function(data){
                        return data + "%";
                    }
                },
                {
                    "data" : "freeback_rate",
                    "render" : function(data){
                        return data + "%";
                    }
                },
                {
                    "data" : "store_type",
                    "render" : function(data){
                        if(data == "physical")
                            return "@lang('pages_text.store_type_offline')";
                        if(data == "online")
                            return "@lang('pages_text.store_type_online')";
                        if(data == "both")
                            return "@lang('pages_text.store_type_both')";
                    }
                },
                {"data" : "created_at"},
                {"data" : "referral_code"},
                {"data" : "invited_by"},
                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="stores/' + data + '\" class="btn btn-success"> @lang('admin.table_details') </a>';
                        return btn;
                    }
                }
            ]
        });
    </script>
@endsection