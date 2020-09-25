@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_app_banners') @endsection

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
                        <h5>@lang('admin.app_banners_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.app_banners_subheading') </h6>
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
                    <div class="card-header">@lang('admin.add_new_banner_panel_title')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.create_banner.submit') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="bannerPhoto">@lang('admin.banner_photo_bg')</label>
                                <input class="form-control" id="bannerPhoto" placeholder="@lang('admin.banner_photo_bg_placeholder')" type="file" name="bannerBackground" required>
                            </div>
                            <div class="form-group">
                                <label for="langSelect">@lang('admin.banner_text')</label>
                                <input class="form-control" id="bannerPhoto" placeholder="@lang('admin.banner_text_placeholder')" type="text" name="bannerText" required>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.add_banner_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.available_banners')</div>
                    <div class="card-body">
                        <table id="bannersTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.banner_table_id')</th>
                                <th>@lang('admin.banner_table_image')</th>
                                <th>@lang('admin.banner_table_text')</th>
                                <th>@lang('admin.banner_table_status')</th>
                                <th>@lang('admin.banner_table_actions')</th>
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
        $('#bannersTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_app_banners')}}","dataSrc":""},
            "columns" : [
                {"data" : "id"},
                {
                    "data" : "background_url",
                    "render" : function(data){
                        return "<img width=\"220px\" height=\"140px\" src=\"" + data + "\">";
                    }
                },
                {"data" : "text"},
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
                        var btn = '<a href="app_banners/switch/' + data + '\" class="btn btn-warning"> @lang('admin.enable_disable')</a>';
                        return btn ;
                    }
                }
            ]
        });
    </script>
@endsection