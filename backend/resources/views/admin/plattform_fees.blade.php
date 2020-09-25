@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_plattform_fees') @endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-user-add"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.plattform_fees_heading')</h5>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="right-actions">
                        <span class="last-login">@lang('admin.stores_update') {{$fees->updated_at->format('d/m/y-h:i')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">


        <div class="row gutters">

            @if(\Illuminate\Support\Facades\Session::has('updated'))
                <div class="col-lg-12">
                    <div class="alert custom alert-success">
                        <i class="icon-tick"></i>@lang('admin.updated_msg')
                    </div>
                </div>
                {{\Illuminate\Support\Facades\Session::forget('updated')}}
            @endif



            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.manage_fees_title')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.update_fees.submit') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="catName">@lang('admin.user_fee')</label>
                                <input class="form-control" id="catName" placeholder="@lang('admin.user_fee')" type="number" step="0.01" name="user_import" value="{{ number_format($fees->user_import,2) }}">
                            </div>

                            <div class="form-group">
                                <label for="catName">@lang('admin.store_fee')</label>
                                <input class="form-control" id="catName" placeholder="@lang('admin.store_fee')"  type="number" step="0.01" name="store_import" value="{{ number_format($fees->store_import,2)}}">
                            </div>

                            <div class="form-group">
                                <label for="catName">@lang('admin.transaction_fee')</label>
                                <input class="form-control" id="catName" placeholder="@lang('admin.transaction_fee')" type="number" step="0.01" name="transaction_import" value="{{ number_format($fees->transaction_import,2) }}">
                            </div>

                            <div class="form-group">
                                <label for="catName">@lang('admin.royalty_fee')</label>
                                <input class="form-control" id="catName" placeholder="@lang('admin.royalty_fee')" type="number" step="0.01" name="royalty_fee" value="{{ number_format($fees->royalty_fee,2) }}">
                            </div>

                            <div class="form-group">
                                <label>@lang('admin.minimum_amount_withdraw')</label>
                                <input class="form-control" placeholder="@lang('admin.minimum_amount_withdraw')" type="number" step="1" name="minimum_requestable_import" value="{{ number_format($fees->minimum_requestable_import,2) }}">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.update_fees_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

