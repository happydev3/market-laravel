@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.create_branch') @endsection

@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.create_branch_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form action="{{route('store.branch.create.submit')}}" method="POST" id="address-form">

                {{csrf_field()}}
                <div class="form-box-item full">
                    <!-- INPUT CONTAINER  Street Address -->
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.address_field_label')</label>
                        <input type="text" id="address" name="formatted_address" placeholder="@lang('store_panel.address_field_placeholder')">
                    </div>

                    <div id="address_map" style="height:450px; width:100%; "></div>
                    <input id="store_lat" name="lat" type="text" value="" style="display: none">
                    <input id="store_lng" name="lng" type="text" value="" style="display: none">

                    <hr class="line-separator">
                    <button class="button big dark" id="update_address_btn">@lang('store_panel.create_branch_button')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.store_address_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.address_guideline1')</p>
                        <p>@lang('store_panel.address_guideline_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.address_guideline2')</p>
                        <p>@lang('store_panel.address_guideline2_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.help_title')</p>
                        <p><a href="{{route('store.help')}}" class="primary">@lang('store_panel.help_request')</a></p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->
                </div>
                <!-- /PLAIN TEXT BOX -->
            </div>
            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->

        <div class="clearfix"></div>
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection

@section('custom_js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFVt2WccdiOFmDTQhNaahcgp_v5yUhMRA&language=it&libraries=places"></script>
    <script src="{{URL::to('js/jquery.geocomplete.min.js')}}"></script>
    <script src="{{URL::to('js/gmaps.js')}}"></script>
    <script>

        $('#address').geocomplete({
            details : "form",
            country: "IT",
            map: "#address_map",
            markerOptions: {
                icon: '{{URL::to('images/logo_mobile.png')}}',
            },
        });

        $('#update_address_btn').click(function(){
            if($('#store_lat').val() != "" && $('#store_lng') != ""){
                $('#address-form').submit();
            }
        });
    </script>
@endsection