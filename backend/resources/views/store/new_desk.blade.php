@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.add_cash_desk') @endsection

@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.create_cash_desk_panel')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form action="{{route('store.branch.cashdesk.new.submit')}}" method="POST">
                {{csrf_field()}}
                <div class="form-box-item full">
                    <input type="hidden" value="{{$branchId}}" name="branch_id">
                    <div class="input-container">
                        <label for="deskName" class="rl-label required">@lang('store_panel.cash_desk_name')</label>
                        <input type="text" id="deskName" name="desk_name" placeholder="@lang('store_panel.cash_desk_name_placeholder')">
                    </div>
                    <button class="button big dark" id="update_address_btn">@lang('store_panel.cash_desk_add_btn')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <div class="form-box-item full">
                <h4>@lang('store_panel.cash_desk_guideline_title')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.cash_desk_guideline1_title')</p>
                        <p>@lang('store_panel.cash_desk_guideline1_text')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.cash_desk_guideline2_title')</p>
                        <p>@lang('store_panel.cash_desk_guideline2_text')</p>
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
        </div>

        <div class="clearfix"></div>
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection
