@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.manage_branches') @endsection

@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.branches_page_title')</h4>
            <a href="{{route('store.branch.create')}}" class="button small primary">@lang('store_panel.add_branch')</a>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full not-padded not-spaced">
                <h4>@lang('store_panel.branches_page_title')</h4>
                <hr class="line-separator">
                @foreach($branches as $b)
                    <div class="recent-activity">
                        <div class="recent-activity-item">
                            <span class="sl-icon icon-globe-alt"></span>
                            <div class="recent-activity-item-timestamp">
                                <p>{{$b->created_at->format('d/m/20y')}}</p>
                            </div>
                            <div class="recent-activity-item-info">
                                <p><bold>{{$b->street_address}}</bold> <span>  </span>/   <a style="color:black" href="{{route('store.branch.edit',['id'=>$b->id])}}">@lang('store_panel.edit_branch')</a> / <a href="{{route('store.branch.switch',['id'=>$b->id])}}" style="color:red">@if($b->active == 1) @lang('store_panel.disable_branch') @else @lang('store_panel.enable_branch') @endif</a> <a href="{{route('store.branch.cashdesks',['id' => $b->id])}}">  / @lang('store_panel.cash_desk_manage')</a> </p>
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
                <h4>@lang('store_panel.branches_guideline_title')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.branches_guideline1_title')</p>
                        <p>@lang('store_panel.branches_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.branches_guideline2_title')</p>
                        <p>@lang('store_panel.branches_guideline2_desc')</p>
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