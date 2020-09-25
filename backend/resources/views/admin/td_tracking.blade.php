@extends('admin.layouts.admin_layout')

@section('page_title') TradeDoubler Tracking - Administration Area Freeback @endsection

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
                        <i class="icon-all_inclusive"></i>
                    </div>
                    <div class="page-title">
                        <h5>TradeDoubler Tracking</h5>
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
                    <div class="card-header">TradeDoubler Trackings</div>
                    <div class="card-body">
                        <table id="transactionsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_date')</th>
                                <th>@lang('admin.transaction_table_user')</th>
                                <th>Tracking ID</th>
                                <th>Target</th>
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
            "ajax" : {"url" : " {{route('admin.ajax_td_tracking')}}","dataSrc":""},
            "columns" : [
                {"data" : "created_at"},
                {"data" : "user.name"},
                {"data" : "subscription_id"},
                {"data" : "td_store.name"},
            ]
        });

    </script>
@endsection