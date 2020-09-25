@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_user_details') @endsection

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
                        <i class="icon-user"></i>
                    </div>
                    <div class="page-title">
                        <h5>{{$user->name}} @lang('admin.user_details_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.user_details_subheading') {{$user->created_at->format('d/m/20y')}}</h6>
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

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <a class="block-300 center-text">
                    <div class="user-profile">
                        <img src="{{URL::to($user->userAvatarLink())}}" class="profile-thumb" alt="User Thumb">
                        <h5 class="profile-name">{{$user->name}}</h5>
                        <h6 class="profile-designation">@lang('admin.user_details_subheading') {{$user->created_at->format('d/m/20y')}}</h6>
                        <p>@lang('admin.user_details_email') {{$user->email}}</p>
                        <p>@lang('admin.user_details_phone_no') {{$user->phone_no}}</p>
                        <p class="profile-location">{{$user->city->city_name}}</p>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col">
                <a class="block-140">
                    <div class="icon primary">
                        <i class="icon-shopping-cart2"></i>
                    </div>
                    <h5>No Cart</h5>
                    <p>@lang('admin.items_in_cart')</p>
                </a>
                <a  class="block-140">
                    <div class="icon primary">
                        <i class="icon-heart"></i>
                    </div>
                    <h5>{{$user->favourites->count()}}</h5>
                    <p>@lang('admin.items_favourite')</p>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col">
                <a class="block-140">
                    <div class="icon primary">
                        <i class="icon-shopping-cart2"></i>
                    </div>
                    <h5>{{$user->online_transactons->count()}}</h5>
                    <p>@lang('admin.online_transactions_done')</p>
                </a>
                <a class="block-140">
                    <div class="icon primary">
                        <i class=icon-barcode></i>
                    </div>
                    <h5>{{ $user->transactions->count() }}</h5>
                    <p>@lang('admin.offline_transactions_done')</p>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col">
                <a class="block-140">
                    <div class="icon primary">
                        <i class="icon-thumbs_up_down"></i>
                    </div>
                    <h5>{{ $user->reviews->count() }}</h5>
                    <p>@lang('admin.reviews_done')</p>
                </a>
                <a class="block-140">
                    <div class="icon primary">
                        <i class="icon-users"></i>
                    </div>
                    <h5>{{ App\Models\User::where('referral_code',$user->own_referral_code)->count()}}</h5>
                    <p>@lang('admin.invited_friends')</p>
                </a>
            </div>
        </div>

        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.online_transactions') </div>
                    <div class="card-body">
                        <table id="onlineTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_store')</th>
                                <th>@lang('admin.transaction_table_id')</th>
                                <th>@lang('admin.transaction_table_import')</th>
                                <th>@lang('admin.transaction_table_cashback')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.offline_transactions_done')</div>
                    <div class="card-body">
                        <table id="offlineTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_store')</th>
                                <th>@lang('admin.transaction_table_id')</th>
                                <th>@lang('admin.transaction_table_import')</th>
                                <th>@lang('admin.transaction_table_cashback')</th>
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
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.search_history_table')</div>
                    <div class="card-body">
                        <table id="searchTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.search_table_id')</th>
                                <th>@lang('admin.search_table_date')</th>
                                <th>@lang('admin.search_table_type')</th>
                                <th>@lang('admin.search_table_query')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.store_visits_table')</div>
                    <div class="card-body">
                        <table id="visitTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.visit_table_id')</th>
                                <th>@lang('admin.visit_table_date')</th>
                                <th>@lang('admin.visit_table_store')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row ends -->

    </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $('#offlineTable').DataTable({
            "iDisplayLenght" : 6,
            "aaSorting": [[0,'desc']],
            "ajax": {"url": "{{route('admin.ajax_user_offline_tr',['id'=>$user->id])}}","dataSrc":""},
            "columns": [
                {"data": "store.business_name"},
                {
                    "data": "id",
                    "render": function (data) {
                        return "TR_"+data;
                    }
                },
                {
                    "data": "full_import",
                    "render": function (data) {
                        return data.toFixed(2) + "€";
                    }
                },
                {
                    "data": "cashback_neto",
                    "render": function(data){
                        return data.toFixed(2) + "€";
                    }
                }
            ],
        });

        $('#onlineTable').DataTable({
            "iDisplayLenght" : 6,
            "aaSorting": [[0,'desc']],
            "ajax": {"url": "{{route('admin.ajax_user_online_tr',['id'=>$user->id])}}","dataSrc":""},
            "columns": [

                {"data": "store.business_name"},
                {
                    "data": "id",
                    "render": function (data) {
                        return "TR_"+data;
                    }
                },
                {
                    "data": "full_import",
                    "render": function (data) {
                        return data + "€";
                    }
                },
                {
                    "data": "cashback_neto",
                    "render": function(data){
                        return data + "€";
                    }
                }
            ],
        });

        $('#searchTable').DataTable({
            "iDisplayLenght" : 6,
            "aaSorting": [[0,'desc']],
            "ajax": {"url": "{{route('admin.ajax_user_search_q',['id'=>$user->id])}}","dataSrc":""},
            "columns": [

                {
                    "data": "id",
                    "render": function (data) {
                        return "SEARCH_"+data;
                    }
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "search_type",
                },
                {
                    "data": "search_query",
                }
            ],
        });

        $('#visitTable').DataTable({
            "iDisplayLenght" : 6,
            "aaSorting": [[0,'desc']],
            "ajax": {"url": "{{route('admin.ajax_user_store_visits',['id'=>$user->id])}}","dataSrc":""},
            "columns": [
                {
                    "data": "id",
                    "render": function (data) {
                        return "VISIT_"+data;
                    }
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "store.business_name",

                }
            ],
        });
    </script>

@endsection



