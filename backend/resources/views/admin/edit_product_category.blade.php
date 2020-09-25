@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_edit_product_category') @endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-shop2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.edit_product_category_heading')</h5>
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
                    <div class="card-header">@lang('admin.edit_category')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.product_category_edit.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="categoryId" value="{{$productCategory->id}}">
                            <div class="form-group">
                                <label for="catName">@lang('admin.category_name_label')</label>
                                <input class="form-control" id="catName" placeholder="@lang('admin.category_name_placeholder')" type="text" name="categoryName" value="{{ $productCategory->name }}">
                            </div>
                            <div class="form-group">
                                <label for="langSelect">@lang('admin.language_label')</label>
                                <select class="form-control" name="categoryLang">
                                    <option value="it">IT</option>
                                    <option value="en">EN</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.update_category_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

