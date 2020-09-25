@extends('marketplace.layouts.main_layout')

@section('custom_css')
    <style type="text/css">
        #map {
            width: 100%;
            height: 550px;
            background-color: grey;
        }
    </style>
@endsection

@section('page_title') @lang('page_titles.around_you_page') @endsection


@section('page_content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="map">
                </div>
        </div>
    </div>
@endsection


@section('custom_js')
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
                            var freebackRate = v.freeback_rate;
                            $.each(v.branches, function(k,v){
                                var contentString = "<div>" +
                                                    "<h3 style=\"color:black;\">" + storeName + "</h3>" +
                                                    "<h4> Cashback: " + (discountRate - (freebackRate / 100) * discountRate) + "%</h4>" +
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
@endsection