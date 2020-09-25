@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_store_categories') @endsection

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
                        <i class="icon-shop"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.store_categories_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.store_categories_subheading') {{ $storeCategoriesCount }}</h6>
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
                    <div class="card-header">@lang('admin.add_store_category_panel')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.new_store_category.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="catName">@lang('admin.category_name_label')</label>
                                <input class="form-control" id="catName" placeholder="@lang('admin.category_name_placeholder')" type="text" name="categoryName" required>
                            </div>
                            <div class="form-group">
                                <label for="langSelect">@lang('admin.language_label')</label>
                                <select class="form-control" id="langSelect" name="categoryLang" required>
                                    <option value="it">IT</option>
                                    <option value="en">EN</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.add_category_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.categories_table_title')</div>
                    <div class="card-body">
                        <table id="categoriesTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.category_table_id')</th>
                                <th>@lang('admin.category_table_name')</th>
                                <th>@lang('admin.category_table_lang')</th>
                                <th>@lang('admin.category_table_status')</th>
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
        $('#categoriesTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_store_categories')}}","dataSrc":""},
            "columns" : [
                {"data" : "id"},
                {"data" : "name"},
                {"data" : "lang"},
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
                        var btn = '<a href="store_category/switch/' + data + '\" class="btn btn-warning"> @lang('admin.enable_disable')</a>';
                        var btn2 = '  <a href="store_category/edit/' + data + '\" class="btn btn-success"> @lang('admin.edit_category')</a>';
                        return btn + btn2;
                    }
                }
            ]
        });
    </script>
@endsection