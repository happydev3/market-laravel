@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.generate_qr_pagetitle') @endsection

@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.generate_qr')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
                <div class="form-box-item full">
                <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.total_import')</label>
                        <input type="text" id="qr_amount" name="qr_code" placeholder="@lang('store_panel.import_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <div class="clearfix"></div>
                    <p id="qr" align="center"></p>

                    <hr class="line-separator">
                    <button class="button big dark" id="generate_qr_btn">@lang('store_panel.generate_qr_button')</button>
                </div>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                    <h4>@lang('store_panel.qr_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.import_guide_title')</p>
                        <p>@lang('store_panel.import_guide_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.qr_code')</p>
                        <p>@lang('store_panel.qr_code_desc')</p>
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
        var qrCode = new QRCode('qr');

        $('#generate_qr_btn').click(function () {
            var total = $('#qr_amount').val();
            total = total.replace(',','.');
            $.ajax({
                type : "POST",
                url : "{{route('store.qr.generate')}}",
                data : {"import": total,"_token":"{{csrf_token()}}"},
                success: function (response) {
                    qrCode.makeCode(response.qr_code);
                }
            })
        })

    </script>

@endsection