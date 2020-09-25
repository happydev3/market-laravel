@extends('user.layouts.dashboard_layout')

@section('page_title')  @lang('page_titles.phone_verify') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/magnific-popup.css')}}">
@endsection


@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('user_panel.phone_verify_panel_title')</h4>
            <a href="{{route('user.verify_phone.resend')}}" class="button mid-short primary">@lang('user_panel.resend_sms_btn')</a>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form method="POST" action="{{route('user.phone_verify.submit')}}">
                <div class="form-box-item full">
                    {{csrf_field()}}
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('user_panel.phone_code_label')</label>
                        <input type="text" id="item_name" name="verify_code" placeholder="@lang('user_panel.phone_code_placeholder')">
                    </div>

                    @if(\Illuminate\Support\Facades\Session::has('phone_verified'))
                        <h6 class="primary">@lang('user_panel.phone_verified_msg')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('phone_verified')}}
                        <div class="clearfix"></div>
                    @endif

                    @if(\Illuminate\Support\Facades\Session::has('wrong_code'))
                        <h6 class="primary" style="color:red">@lang('user_panel.phone_verified_error_msg')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('wrong_code')}}
                        <div class="clearfix"></div>
                    @endif

                    @if(\Illuminate\Support\Facades\Session::has('sms_sent'))
                        <h6 class="primary">@lang('user_panel.sms_sent_again')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('sms_sent')}}
                        <div class="clearfix"></div>
                    @endif


                    <div class="clearfix"></div>
                    <button class="button big dark" type="submit">@lang('user_panel.phone_code_button')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('user_panel.phone_verify_guideline')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.verify_guideline1_title')</p>
                        <p>@lang('user_panel.verify_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.verify_guideline2_title')</p>
                        <p>@lang('user_panel.verify_guideline2_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.help_title')</p>
                        <p><a href="{{route('user.help')}}" class="primary">@lang('user_panel.help_desc')</a></p>
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
    <!-- xmAlert -->
    <script src="{{URL::to('js/vendor/jquery.xmalert.min.js')}}"></script>
    <!-- Magnific Popup -->
    <script src="{{URL::to('js/vendor/jquery.magnific-popup.min.js')}}"></script>
@endsection