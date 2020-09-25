@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.store_bank_account') @endsection
@section('custom_css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet" type="text/css" />
@endsection


@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.bank_account_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form method="POST" action="{{route('store.banking.submit')}}">
                <div class="form-box-item full">
                {{csrf_field()}}
                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="iban" class="rl-label required">@lang('store_panel.entrance_iban')</label>
                        <input type="text" id="iban" name="entrance_iban" value="@if(Auth::guard('store')->user()->bank_info != null){{Auth::guard('store')->user()->bank_info->entrance_iban}}@endif" placeholder="@lang('store_panel.entrance_iban_placeholder')" required data-validation="required custom" data-validation-regexp="^IT\d{2}[A-Z]\d{10}[0-9A-Z]{12}$">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    @if(\Illuminate\Support\Facades\Session::has('store_bank_info_updated'))
                        <h6 class="primary">@lang('user_panel.iban_updated_msg')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('store_bank_info_updated')}}
                        <div class="clearfix"></div>
                    @endif

                    @if(\Illuminate\Support\Facades\Session::has('store_invalid_iban'))
                        <h6 class="primary" style="color:red">@lang('store_panel.invalid_iban_msg')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('store_invalid_iban')}}
                        <div class="clearfix"></div>
                    @endif

                    <div class="clearfix"></div>
                    <button class="button big dark" type="submit">@lang('store_panel.bank_info_update_iban')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.bank_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.guideline_1_title')</p>
                        <p>@lang('store_panel.guideline_1_desc')</p>
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>

        $('#iban').on('input', function(evt) {
            $(this).val(function(_, val) {
                return val.toUpperCase();
            });
        });

        $.validate({
            lang: '{{App::getLocale()}}',
        });


    </script>

@endsection

