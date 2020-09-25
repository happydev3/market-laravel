@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.add_tradedoubler_discount') @endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-shop2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.add_discount_rate_panel_title') {{$tdStore->name}}</h5>
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
                    <div class="card-header">@lang('admin.add_discount_rate_panel_title') {{$tdStore->name}}</div>
                    <div class="card-body">
                        <form action="{{ route('admin.tradedoubler.discount.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="tdStoreId" value="{{$tdStore->id}}">
                            <div class="form-group">
                                <label for="item1">@lang('admin.category_name')</label>
                                <input class="form-control" id="item1" placeholder="@lang('admin.td_category_name_placeholder')" type="text" name="category" value="">
                            </div>

                            <div class="form-group">
                                <label for="item1">@lang('admin.category_discount_rate')</label>
                                <input class="form-control" id="item2" placeholder="@lang('admin.category_discount_rate_placeholder')" type="number" min="0.1" max="99.9" step="0.01" name="cashback" value="">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.add_discount_rate')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection