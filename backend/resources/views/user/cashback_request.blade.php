@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.require_cashback') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('user_panel.cashback_request_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item">
                <h4>@lang('user_panel.cashback_require_form')</h4>
                <hr class="line-separator">

                @if(\Illuminate\Support\Facades\Session::has('CASHBACK_REQUEST_ERROR'))
                    <p>@lang('user_panel.cashback_request_error')</p>
                    {{\Illuminate\Support\Facades\Session::forget('CASHBACK_REQUEST_ERROR')}}
                @endif

                @if(\Illuminate\Support\Facades\Session::has('CASHBACK_REQUEST_SENT'))
                    <p>@lang('user_panel.cashback_request_success')</p>
                    {{\Illuminate\Support\Facades\Session::forget('CASHBACK_REQUEST_SENT')}}
                @endif


                @if($amount >= $minimumRequestable)
                    <form id="withdraw-form" method="POST" action="{{route('user.request.cashback')}}">
                        {{csrf_field()}}
                        <!-- INPUT CONTAINER -->
                        <div class="input-container">
                            <h3 class="rl-label required">@lang('user_panel.max_amount_pt1') €{{number_format($amount,2)}}</h3>
                        </div>
                        <!-- /INPUT CONTAINER -->
                        <!-- INPUT CONTAINER -->
                        <div class="input-container">
                            <label for="pp_ac" class="rl-label required">@lang('user_panel.withdraw_iban_label')</label>
                            <input type="text" name="iban" placeholder="@lang('user_panel.withdraw_iban_placeholder')" required>
                            <p>@lang('user_panel.cashback_request_info')</p>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container">
                            <label for="pwd_ac" class="rl-label required">@lang('user_panel.password_label')</label>
                            <input type="password" name="password" placeholder="@lang('user_panel.password_placeholder')" required>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <hr class="line-separator">

                        <button type="submit" class="button big dark">@lang('user_panel.require_btn1')<span class="primary">@lang('user_panel.require_btn2')</span></button>
                    </form>
                @else
                    <p>@lang('user_panel.no_cashback_message') {{number_format($amount,2)}}€ @lang('user_panel.no_cashback_message_tail') {{number_format($minimumRequestable,2)}}€.</p>
                @endif
            </div>
            <!-- /FORM BOX ITEM -->

            <!-- FORM BOX ITEM -->
            <div class="form-box-item withdraw-history">
                <h4>@lang('user_panel.cashback_request_history')</h4>
                <hr class="line-separator">
                <!-- TRANSACTION HISTORY -->
                <div class="transaction-history">
                    @if(count($cashbackRequests) > 0 )
                        @foreach($cashbackRequests as $request)
                            <div class="transaction-history-item">
                                <div class="transaction-history-item-date">
                                    <p>{{$request->created_at->format('d/m/20y')}}</p>
                                </div>
                                <div class="transaction-history-item-mail">
                                    <p>{{substr_replace($request->iban,'**************',4,11)}}</p>
                                </div>
                                <div class="transaction-history-item-amount">
                                    <p class="text-header">€{{number_format($request->import,2)}}</p>
                                </div>
                                <div class="transaction-history-item-status">
                                    @if($request->status == "accepted")
                                        <p class="text-header">@lang('user_panel.cashback_request_status_pending')</p>
                                    @else
                                        <p class="text-header">@lang('user_panel.cashback_request_status_paid')</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>@lang('user_panel.no_cashback_requests')</p>
                    @endif
                    <!-- TRANSACTION HISTORY ITEM -->
                </div>
                <!-- /TRANSACTION HISTORY -->
                <div class="pager-wrap">
                    {{$cashbackRequests->links()}}
                </div>
            </div>
            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->
    </div>
    <!-- DASHBOARD CONTENT -->








@endsection