@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_edit_store_category') @endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-list"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.cashback_request_details_heading')</h5>
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
                    <div class="card-header">@lang('admin.table_details')</div>
                    <div class="card-body">
                            <div class="form-group">
                                <label>@lang('admin.cashback_request_user')</label>
                                <p>{{$cashbackRequest->user->name}}</p>
                            </div>
                            <div class="form-group">
                                <label>@lang('admin.cashback_request_iban')</label>
                                <p>{{$cashbackRequest->iban}}</p>
                            </div>
                            <div class="form-group">
                                <label>@lang('admin.cashback_request_import')</label>
                                <p>{{number_format($cashbackRequest->import,2)}}€</p>
                            </div>
                            <div class="form-group">
                                <label>@lang('admin.cashback_request_status')</label>
                                @if($cashbackRequest->status == "accepted")
                                    <p>@lang('user_panel.cashback_request_status_pending')</p>
                                @else
                                    <p>@lang('user_panel.cashback_request_status_paid')</p>
                                @endif

                            </div>
                            @if($cashbackRequest->status == "accepted")
                                <div class="form-group">
                                    <a href="{{route('admin.cashback_request.process',['id'=>$cashbackRequest->id])}}" class="btn btn-success">@lang('admin.cashback_request_processed_btn')</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection