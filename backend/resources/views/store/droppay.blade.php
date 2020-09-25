@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.store_documents')  @endsection


@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('auth.connect_droppay')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <div class="form-box-item full">
                @if($dropPayConfig->dp_connected)
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('auth.connect_droppay_label')</label>
                        <p>@lang('auth.droppay_connected')</p>
                        <br/>
                    </div>
                @else
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('auth.connect_droppay_label')</label>
                        <p hidden id="dpConnectionCode">{{$dropPayConfig->dp_connection_id}}</p>
                        <p>@lang('auth.connect_droppay_desc')</p>
                        <p>@lang('auth.no_account_droppay')</p>
                        <br/>
                        <p id="connectionQr" align="center" hidden></p>
                        <br/>
                        <button class="button small dark" id="showConnectionQr">@lang('auth.connect_droppay_btn')</button>
                    </div>
                @endif

                @if($dropPayConfig->dp_pull_granted)
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('auth.droppay_pull_auth_title')</label>
                        <p>@lang('auth.droppay_pull_authorized')</p>
                        <br/>
                    </div>
                @else
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('auth.droppay_pull_auth_title')</label>
                        <p hidden id="dpPullId">{{$dropPayConfig->dp_pull_id}}</p>
                        <p>@lang('auth.droppay_pull_auth_text')</p>
                        <br/>
                        <p id="pullQr" align="center" hidden></p>
                        <br/>
                        <button class="button small dark" id="showPullQr">@lang('auth.droppay_pull_auth_btn')</button>
                    </div>
                @endif
            </div>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('auth.dp_guidelines_title')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('auth.dp_guideline1_title')</p>
                        <p>@lang('auth.dp_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('auth.dp_guideline2_title')</p>
                        <p>@lang('auth.dp_guideline2_desc')</p>
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

    <script src="{{URL::to('js/vendor/qrcode.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var connected;
            var pullAuthorized;

            function getDpStatus(){
                return $.ajax({
                    url: "{{route('store.droppay.check')}}",
                    success: function(data){
                        connected = data.connection;
                        pullAuthorized = data.pull;
                    }
                });
            }

            $.when(getDpStatus()).done(function(){
                if(connected != 1){
                    var connectionQrCode = new QRCode('connectionQr');
                    var dpConnectionId = $('#dpConnectionCode').text();
                    $('#showConnectionQr').click(function () {
                        connectionQrCode.makeCode("https://dp.link/u/20/" + dpConnectionId);
                        $('#connectionQr').removeAttr('hidden');
                    });
                }

                if(pullAuthorized != 1){
                    var pullQrCode = new QRCode('pullQr');
                    var dpPullId = $('#dpPullId').text();
                    $('#showPullQr').click(function () {
                        pullQrCode.makeCode("https://dp.link/u/2/" + dpPullId);
                        $('#pullQr').removeAttr("hidden");
                    });
                }
            });

            setInterval(function(){
                console.log("Called");
                $.ajax({
                    url: "{{route('store.droppay.check')}}",
                    success: function(data){
                        if(data.connection != connected){
                            location.reload();
                        }
                        if(data.pull != pullAuthorized ){
                            location.reload();
                        }
                    }
                });
            }, 3000);

        });
    </script>

@endsection