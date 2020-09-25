@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.discount_rate') @endsection

@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.discount_rate')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form method="POST" action="{{route('store.edit.discount')}}">
                <div class="form-box-item full">
                {{csrf_field()}}
                <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.discount_rate') (%)</label>
                        <input type="number" id="discount_value" name="discount_rate" value="{{Auth::guard('store')->user()->discount_rate}}" step="0.1" max="99" min="0.1" placeholder="@lang('store_panel.discount_rate_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    @if(\Illuminate\Support\Facades\Session::has('discount_updated'))
                        <h6 class="primary">@lang('store_panel.discount_rate_updated')</h6> <br/>
                        {{\Illuminate\Support\Facades\Session::forget('discount_updated')}}
                        <div class="clearfix"></div>
                    @endif


                    <div class="clearfix"></div>

                    <hr class="line-separator">
                    <button class="button big dark" type="submit">@lang('store_panel.discount_rate_btn')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.discount_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.discount_rate_guide1')</p>
                        <p>@lang('store_panel.discount_rate_desc1')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.discount_rate_guide2')</p>
                        <p>@lang('store_panel.discount_rate_desc2')</p>
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
