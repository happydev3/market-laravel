@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_newsletter') @endsection

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
                        <i class="icon-mail5"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.newsletter_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.newsletter_subheading')</h6>
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
                    <div class="card-header">@lang('admin.registered_users_table_title')</div>
                    <div class="card-body">
                        <table id="newsletterUsers" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.users_table_name')</th>
                                <th>@lang('admin.users_table_email')</th>
                                <th>@lang('admin.users_table_phone')</th>
                                <th>@lang('admin.users_table_city')</th>
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
                    <div class="card-header">@lang('admin.external_users_table_title')</div>
                    <div class="card-body">
                        <table id="externalNewsletterSubscription" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.users_table_email')</th>
                                <th>@lang('admin.orders_table_date')</th>
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
        $('#newsletterUsers').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_registered_newsletter')}}","dataSrc":""},
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columns" : [
                {"data" : "name"},
                {"data" : "email"},
                {"data" : "phone_no"},
                {"data" : "city.city_name"},
            ]
        });

        $('#externalNewsletterSubscription').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_external_newsletter')}}","dataSrc":""},
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columns" : [
                {"data" : "id"},
                {"data" : "email"},
                {"data" : "created_at"},
            ]
        });

    </script>
@endsection