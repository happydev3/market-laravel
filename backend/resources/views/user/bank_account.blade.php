@extends('user.layouts.dashboard_layout')

@section('page_title')  @lang('page_titles.user_bank_config')@endsection

@section('custom_css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet" type="text/css" />
@endsection


@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.bank_conf')  @if(Auth::user()->bank_info != null)
                    - @lang('store_panel.last_updated') {{Auth::user()->bank_info->updated_at->format('d/m/20y - H:i')}} @endif</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form method="POST" action="{{route('user.bank_account.submit')}}">
                <div class="form-box-item full">
                    {{csrf_field()}}
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('user_panel.entrance_iban')</label>
                        <input type="text" id="entrance_iban" name="income_iban"
                               value="@if(Auth::user()->bank_info != null) {{Auth::user()->bank_info->income_iban}} @endif"
                               placeholder="@lang('user_panel.entrance_iban_placeholder')" required data-validation="required custom" data-validation-regexp="^IT\d{2}[A-Z]\d{10}[0-9A-Z]{12}$">
                    </div>
                    @if(\Illuminate\Support\Facades\Session::has('bank_info_updated'))
                        <h6 class="primary">@lang('user_panel.iban_updated_msg')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('bank_info_updated')}}
                        <div class="clearfix"></div>
                    @endif

                    @if(\Illuminate\Support\Facades\Session::has('invalid_iban'))
                        <h6 class="primary" style="color:red">@lang('user_panel.invalid_iban_msg')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('invalid_iban')}}
                        <div class="clearfix"></div>
                    @endif

                    <div class="clearfix"></div>
                    <button class="button big dark" type="submit">@lang('user_panel.bank_update_btn')</button>
                </div>
            </form>

            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('user_panel.bank_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.bank_info_guideline_dp')</p>
                        <p>@lang('user_panel.bank_info_guideline_do_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.guideline_2_title')</p>
                        <p>@lang('user_panel.guideline_2_desc')</p>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>

        $('#entrance_iban').on('input', function(evt) {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });

        $.validate({
            lang: '{{App::getLocale()}}',
        });


    </script>
@endsection
