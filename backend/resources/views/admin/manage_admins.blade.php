@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_manage_admins') @endsection

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
                        <i class="icon-eye"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.manage_admins_header')</h5>
                        <h6 class="sub-heading">@lang('admin.manage_admins_subheader')</h6>
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
                    <div class="card-header">@lang('admin.create_new_admin_account')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.create_admin.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="adminName">@lang('admin.admin_name_label')</label>
                                <input class="form-control" id="adminName" placeholder="@lang('admin.admin_name_placeholder')" type="text" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="adminMail">@lang('admin.admin_email_label')</label>
                                <input class="form-control" id="adminMail" placeholder="@lang('admin.admin_email_placeholder')" type="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="adminPwd">@lang('admin.password_label')</label>
                                <input class="form-control" id="adminPwd" placeholder="@lang('admin.password_placeholder')" type="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.add_admin_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.admins_table_title')</div>
                    <div class="card-body">
                        <table id="adminTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.category_table_id')</th>
                                <th>@lang('admin.category_table_name')</th>
                                <th>E-Mail</th>
                                <th>@lang('admin.product_status')</th>
                                <th>@lang('admin.category_table_actions')</th>
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
        $('#adminTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_get_admins')}}","dataSrc":""},
            "columns" : [
                {"data" : "id"},
                {"data" : "name"},
                {"data" : "email"},
                {
                    "data" : "active",
                    "render" : function(data){
                        if(data == 1) {
                            return "<span class=\"badge badge-success\">@lang('admin.status_active')</span>";
                        } else {
                            return "<span class=\"badge badge-primary\">@lang('admin.status_deactive')</span>";
                        }
                    }
                },
                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="manage_admins/switch/' + data + '\" class="btn btn-warning"> @lang('admin.enable_disable')</a>';
                        return btn;
                    }
                }
            ]
        });
    </script>
@endsection