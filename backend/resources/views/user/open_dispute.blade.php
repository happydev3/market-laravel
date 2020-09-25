@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.help_center') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('user_panel.dispute_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form method="POST" action="{{route('user.dispute.submit')}}">
                {{csrf_field()}}
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <div class="form-box-item full">
                    <div class="input-container">
                        <label for="item_name" class="rl-label">@lang('user_panel.your_orders_table_product')</label>
                        <p>{{$order->product->title}}</p>
                    </div>
                    <div class="input-container">
                        <label for="item_name" class="rl-label">@lang('user_panel.import_without_cashback')</label>
                        <p>{{number_format($order->online_transaction->full_import,2)}}€</p>
                    </div>
                    <div class="input-container">
                        <label for="item_name" class="rl-label">@lang('user_panel.wallet_table_store')</label>
                        <p>{{$order->store->business_name}}</p>
                    </div>
                    <div class="input-container">
                        <label for="item_name" class="rl-label">@lang('user_panel.full_address')</label>
                        <p>{{$order->store->getAddress()->street_address}}</p>
                    </div>
                    <div class="input-container">
                        <label for="item_name" class="rl-label">@lang('user_panel.phone_no')</label>
                        <p>{{$order->store->phone_number}}</p>
                    </div>
                    <div class="input-container">
                        <label for="item_name" class="rl-label">@lang('user_panel.email_address')</label>
                        <p>{{$order->store->email}}</p>
                    </div>

                    <div class="input-container">
                        <label for="message" class="rl-label required">@lang('user_panel.dispute_msg_label')</label>
                        <textarea name="message" id="message" required placeholder="@lang('user_panel.dispute_msg_placeholder')"></textarea>
                    </div>

                    <hr class="line-separator">
                    <button type="submit" class="button big dark">@lang('user_panel.open_dispute_form_btn')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('user_panel.dispute_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.dispute_guideline1_title')</p>
                        <p>@lang('user_panel.dispute_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('user_panel.dispute_guideline2_title')</p>
                        <p>@lang('user_panel.dispute_guideline2_desc')</p>
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

