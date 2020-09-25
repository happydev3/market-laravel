@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.branch_cash_desk') @endsection

@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.cash_desk_panel_title')</h4>
            <a href="{{route('store.branch.cashdesk.create',['branchId'=>$branchId])}}" class="button small primary">@lang('store_panel.add_cash_desk')</a>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full not-padded not-spaced">
                <h4>@lang('store_panel.cash_desk_manage')</h4>
                <hr class="line-separator">
                @foreach($cashDesks as $c)
                    <div class="recent-activity">
                        <div class="recent-activity-item">
                            <span class="sl-icon icon-wallet"></span>
                            <div class="recent-activity-item-timestamp">
                                <p>{{$c->created_at->format('d/m/20y')}}</p>
                            </div>
                            <div class="recent-activity-item-info">
                                <p><bold> {{$c->desk_name}} - {{$c->code}}</bold> <span>     </span>   <a href="{{route('store.branch.cashdesk.switch',['deskId'=>$c->id,'branchId'=>$branchId])}}" style="color:red">@if($c->active == 1) @lang('store_panel.disable_branch') @else @lang('store_panel.enable_branch') @endif</a> / <a href="{{route('store.branch.cashdesk.download',['id' => $c->id])}}">@lang('store_panel.download_desk_qr')</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- /FORM BOX ITEM -->
            <div class="clearfix"></div>
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

@section('custom_js')

@endsection