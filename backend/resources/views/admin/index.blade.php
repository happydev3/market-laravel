@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_home_title') @endsection

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
                        <i class="icon-laptop_windows"></i>
                    </div>
                    <div class="page-title">
                        <h5>Dashboard</h5>
                        <h6 class="sub-heading">@lang('admin.dashboard_subheader')</h6>
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
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stats-widget">
                            <div class="stats-widget-header">
                                <i class="icon-users"></i>
                            </div>
                            <div class="stats-widget-body">
                                <!-- Row start -->
                                <ul class="row no-gutters">
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h6 class="title">@lang('admin.users_today')</h6>
                                    </li>
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h4 class="total">{{$users_today}}</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stats-widget">
                            <div class="stats-widget-header">
                                <i class="icon-shop2"></i>
                            </div>
                            <div class="stats-widget-body">
                                <!-- Row start -->
                                <ul class="row no-gutters">
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h6 class="title">@lang('admin.stores_today')</h6>
                                    </li>
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h4 class="total">{{$stores_today}}</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stats-widget">
                            <div class="stats-widget-header">
                                <i class="icon-coin-euro"></i>
                            </div>
                            <div class="stats-widget-body">
                                <!-- Row start -->
                                <ul class="row no-gutters">
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h6 class="title">@lang('admin.transactions_today')</h6>
                                    </li>
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h4 class="total">{{$transactions_today}}</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stats-widget">
                            <div class="stats-widget-header">
                                <i class="icon-euro_symbol"></i>
                            </div>
                            <div class="stats-widget-body">
                                <!-- Row start -->
                                <ul class="row no-gutters">
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h6 class="title">@lang('admin.freeback_transaction_full')</h6>
                                    </li>
                                    <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                        <h4 class="total">{{number_format($turnOver,2)}}€</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.stores_subheading')</div>
                    <div class="card-body" id="map" style="height: 400px;">
                    </div>
                </div>
            </div>
        </div>


        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.online_transactions') @lang('admin.today')</div>
                    <div class="card-body">
                        <table id="onlineTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_user')</th>
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
                    <div class="card-header">@lang('admin.offline_transactions') @lang('admin.today')</div>
                    <div class="card-body">
                        <table id="offlineTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_user')</th>
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

    </div>

@endsection

@section('custom_js')
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUW3WELx6FypZdbe54N4KFRpCdhFbkWj4&callback=initMap&lang=IT"></script>
    <script>
        var map, infoWindow;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 41.8919300, lng: 12.5113300},
                zoom: 8
            });
            infoWindow = new google.maps.InfoWindow;

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent("@lang('pages_text.located')");
                    infoWindow.open(map);
                    map.setCenter(pos);
                    map.setZoom(16);

                    loadStoresAndCreateMarker(map);

                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                "@lang('pages_text.located')" :
                "@lang('pages_text.located')");
            infoWindow.open(map);
        }

        function loadStoresAndCreateMarker(map){
            $.ajax({
                url: "{{route('marketplace.around.ajax')}}",
                success: function(data){
                    if(data.length > 0) {
                        $.each(data, function(k,v) {
                            var storeName = v.business_name;
                            var discountRate = v.discount_rate;
                            $.each(v.branches, function(k,v){
                                var contentString = "<div>" +
                                    "<h3 style=\"color:black;\">" + storeName + "</h3>" +
                                    "<h4> Cashback: " + discountRate + "%</h4>" +
                                    "<p>" + v.street_address + "</p>";

                                var infoWindow = new google.maps.InfoWindow({
                                    content: contentString
                                });
                                var pos = {lat: v.lat, lng: v.lng};
                                var marker =  new google.maps.Marker({
                                    position: pos,
                                    map: map,
                                    title: storeName,
                                    icon: "{{URL::to('images/mapmarker.png')}}",
                                });

                                marker.addListener('click',function(){
                                    infoWindow.open(map,marker);
                                });

                            });

                        })
                    }
                },
            });
        }
    </script>

    <script>
        $('#offlineTable').DataTable({
            "iDisplayLenght" : 8,
            "aaSorting": [[0,'desc']],
            "ajax": {"url": "{{route('admin.ajax_today_offline_tr')}}","dataSrc":""},
            "columns": [
                {"data": "user.name"},
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

        $('#onlineTable').DataTable({
            "iDisplayLenght" : 8,
            "aaSorting": [[0,'desc']],
            "ajax": {"url": "{{route('admin.ajax_today_online_tr')}}","dataSrc":""},
            "columns": [
                {"data": "user.name"},
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
    </script>
@endsection