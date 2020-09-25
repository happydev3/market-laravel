@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.help_center') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('user_panel.help_center_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form id="helpForm" method="POST" action="{{ route('store.help_request.submit') }}">
                {{csrf_field()}}
                <div class="form-box-item full">

                    @if(\Illuminate\Support\Facades\Session::has('helpRequest'))
                        <h4 style="color:#00d7b3;">@lang('store_panel.help_request_sent')</h4>
                        <hr class="line-separator">
                        {{\Illuminate\Support\Facades\Session::forget('helpRequest')}}
                    @endif

                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('user_panel.problem_type_label')</label>
                        <select name="problem_type" id="problemType">
                            <option value="@lang('user_panel.help_option1')">@lang('user_panel.help_option1')</option>
                            <option value="@lang('user_panel.help_option2')">@lang('user_panel.help_option2')</option>
                            <option value="@lang('user_panel.help_option3')">@lang('user_panel.help_option3')</option>
                        </select>
                    </div>

                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('user_panel.help_message')</label>
                        <textarea name="message"  id="message" placeholder="@lang('user_panel.help_message_placeholder')" required></textarea>
                    </div>

                    <hr class="line-separator">
                    <button id="helpSend" class="button big dark">@lang('user_panel.help_request_btn')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('user_panel.help_request_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.help_guideline1')</p>
                        <p>@lang('user_panel.help_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.help_guideline2')</p>
                        <p>@lang('user_panel.help_guideline2_desc')</p>
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

@endsection
