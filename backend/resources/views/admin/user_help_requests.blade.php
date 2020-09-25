@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_user_help_request') @endsection

@section('page_content')


    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-help"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.user_help_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.users_help_subheading')</h6>
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
                    <div class="card-header">@lang('admin.users_help_table')</div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('admin.orders_table_user')</th>
                                <th>@lang('admin.request_table_message')</th>
                                <th>@lang('admin.request_table_date')</th>
                                <th>@lang('admin.request_table_answer')</th>
                                <th>@lang('admin.request_table_answer_by')</th>
                                <th>@lang('admin.users_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $r)
                                <tr>
                                    <th scope="row">{{$r->id}}</th>
                                    <td>{{$r->user->name}}</td>
                                    <td>{{substr($r->request,0,40)}}...</td>
                                    <td>{{$r->created_at->format('d/m/20y - h:i')}}</td>
                                    <td>
                                        @if($r->answered)
                                            <span class="badge badge-pill badge-success">@lang('admin.answered')</span>
                                        @else
                                            <span class="badge badge-pill badge-primary">@lang('admin.not_asnwered')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($r->answered)
                                            {{$r->admin->name}}
                                        @else
                                            @lang('admin.not_asnwered')
                                        @endif
                                    </td>
                                    <td>
                                        @if($r->answered)
                                            <a href="{{route('admin.user_help_single_show',['id' => $r->id])}}" class="btn btn-secondary">@lang('admin.open_request')</a>
                                        @else
                                            <a href="{{route('admin.user_help_single',['id'=>$r->id])}}" class="btn btn-success">@lang('admin.answer_btn')</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 pull-right">
                {{$requests->links("vendor.pagination.admin_paginator")}}
            </div>
        </div>
        <!-- Row end -->
    </div>
@endsection