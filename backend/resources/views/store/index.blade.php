@extends('store.layouts.store_layout')

@section('page_title') {{Auth::guard('store')->user()->business_name}} @lang('page_titles.store_dashboard')@endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline statement primary">
            <h4>{{Auth::guard('store')->user()->business_name}} Dashboard</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- SALE DATA -->
        <div class="sale-data">
            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-user"></span>
                <p class="text-header big">{{$visitors}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.visitors_today')</p>
                    <p>@lang('store_panel.visitors_phisical_online')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->

            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-present"></span>
                <p class="text-header big">{{$products}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.products')</p>
                    <p>@lang('store_panel.products_available')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->

            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-tag"></span>
                <p class="price big"><span>€</span>{{number_format($today_total,2)}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.total_sales')</p>
                    <p>@lang('store_panel.total_sales_today')</p>
                </div>
            </div>
            <!-- /SALE DATA ITEM-->

            <!-- SALE DATA ITEM -->
            <div class="sale-data-item">
                <span class="sl-icon icon-wallet"></span>
                <p class="price big"><span>€</span>{{number_format($today_neto,2)}}</p>
                <div class="sale-data-item-info">
                    <p class="text-header">@lang('store_panel.total_earnings')</p>
                    <p>@lang('store_panel.total_earnings_today')</p>
                </div>
            </div>
        </div>
        <!-- /SALE DATA -->



        @if(!Auth::guard('store')->user()->isDropPayConnected())
            <div class="form-box-item full not-padded not-spaced">
                <h4>@lang('store_panel.news_panel')</h4>
                <hr class="line-separator">
                    <div class="recent-activity">
                        <div class="recent-activity-item">
                            <span class="sl-icon icon-rocket"></span>
                            <div class="recent-activity-item-timestamp">
                                <p>{{ now()->format('d/m/20y - h:i') }}</p>
                            </div>
                            <div class="recent-activity-item-info">
                                <p><span class="bold">@lang('store_panel.connect_droppay') : </span> @lang('store_panel.create_droppay_account') - <a style="color:lightseagreen"  target="_blank" href="https://www.drop-pay.com/it/home">@lang('store_panel.create_droppay_account2')</a></p>
                            </div>
                        </div>
                    </div>
                <div class="clearfix"></div>
            </div>
        @endif






        @if(!Auth::guard('store')->user()->storeIsActive())
        <div class="form-box-item full not-padded not-spaced">
            <h4>@lang('store_panel.activate_account')</h4>
            <hr class="line-separator">
            <!-- RECENT ACTIVITY -->
            @if(!Auth::guard('store')->user()->email_verified)
                <div class="recent-activity">
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-rocket"></span>
                        <div class="recent-activity-item-timestamp">
                            <p>{{ now()->format('d/m/20y - h:i') }}</p>
                        </div>
                        <div class="recent-activity-item-info">
                            <p><span class="bold">@lang('user_panel.mail_verify_title') : </span> @lang('user_panel.mail_verify_missing') {{Auth::user()->email}} @lang('user_panel.mail_verify_missing2')</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(Auth::guard('store')->user()->documents->where('valid',1)->count() < 3)
                <div class="recent-activity">
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-rocket"></span>
                        <div class="recent-activity-item-timestamp">
                            <p>{{ now()->format('d/m/20y - h:i') }}</p>
                        </div>
                        <div class="recent-activity-item-info">
                            <p><span class="bold"><a href="{{route('store.documents')}}">@lang('store_panel.load_documents')</a> : </span> @lang('store_panel.load_documents_desc')</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    @endif



        <!-- FORM BOX ITEM -->
        <div class="form-box-item full not-padded not-spaced">
            <h4>@lang('user_panel.recent_activity')</h4>
            <hr class="line-separator">
            <!-- RECENT ACTIVITY -->
            <div class="recent-activity">
                @if(count($activities) < 1)
                    <div class="recent-activity-item">
                        <span class="sl-icon icon-bell"></span>
                        <div class="recent-activity-item-timestamp">
                            <p>@lang('store_panel.no_activity')</p>
                        </div>

                    </div>
                @else
                    @foreach($activities as $activity)
                    <!-- RECENT ACTIVITY ITEM -->
                        <div class="recent-activity-item">
                            <span class="sl-icon icon-present"></span>
                            <div class="recent-activity-item-timestamp">
                                <p>{{$activity->created_at->format('d/m/y - H:m')}}</p>
                            </div>
                            <div class="recent-activity-item-info">
                                <p>{{$activity->text}}</p>
                            </div>
                        </div>
                        <!-- /RECENT ACTIVITY ITEM -->
                    @endforeach
                @endif
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
    <!-- /FORM BOX ITEMS -->
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::to('js/dashboard-statement.js')}}"></script>
@endsection
