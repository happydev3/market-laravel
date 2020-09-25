@extends('marketplace.layouts.main_layout')

@section('page_title') {{$store->name}} @lang('page_titles.single_store_page') @endsection

@section('custom_css') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>{{$store->name}}</h2>
            <p>Home<span class="separator">/</span><span class="current-section">{{$store->name}}</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- AUTHOR PROFILE BANNER -->
    <div class="author-profile-banner" style="background-image: url('{{URL::to($store->getBackgroundUrl())}}')">
    </div>
    <!-- /AUTHOR PROFILE BANNER -->

    <!-- AUTHOR PROFILE META -->
    <div class="author-profile-meta-wrap">
        <div class="author-profile-meta">
            <!-- AUTHOR PROFILE INFO -->
            <div class="author-profile-info">
                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.cashback')</p>
                    <p> @lang('pages_text.cashback_up_to') @if($max_cashback != 0) {{number_format($max_cashback,2)}} % @else N/A @endif</p>
                </div>
                <!-- /AUTHOR PROFILE INFO ITEM -->

                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.category')</p>
                    <p>{{$category->name}}</p>
                </div>


                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.website')</p>
                    <p><a target="_blank" href="{{route('redirect.tradedoubler',['id'=>$store->id])}}" class="primary">@lang('pages_text.visit_website')</a></p>
                </div>
                <!-- /AUTHOR PROFILE INFO ITEM -->
            </div>
            <!-- /AUTHOR PROFILE INFO -->
        </div>
    </div>
    <!-- /AUTHOR PROFILE META -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section overflowable">
            <!-- SIDEBAR -->
            <div class="sidebar left author-profile">
                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item author-bio">
                    <!-- USER AVATAR -->
                    <a href="#" class="user-avatar-wrap medium">
                        <figure class="user-avatar medium">
                            <img src="{{URL::to($store->getLogoUrl())}}" alt="">
                        </figure>
                    </a>
                    <!-- /USER AVATAR -->
                    <p class="text-header">{{$store->name}}</p>
                    <p class="text-oneline">@lang('pages_text.partner_since') {{$store->created_at->format('d/m/20y')}}</p>
                    <a href="{{route('redirect.tradedoubler',['id'=>$store->id])}}" target="_blank" class="button mid dark spaced">@lang('pages_text.visit_partner') {{$store->name}}</a>
                </div>
                <!-- /SIDEBAR ITEM -->

                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item author-reputation full">
                    <h4>@lang('pages_text.partner_times')</h4>
                    <hr class="line-separator">
                    <h6>@lang('pages_text.tracking_time')</h6>
                    <p>
                        @switch($store->tracking_time)
                            @case("day")
                                @lang('pages_text.time_day')
                            @break

                            @case("week")
                                @lang('pages_text.time_week')
                            @break

                            @case("month")
                                @lang('pages_text.time_month')
                            @break

                            @case("3month")
                                @lang('pages_text.time_3month')
                            @break
                        @endswitch
                    </p>
                    <br/>
                    <h6>@lang('pages_text.credit_time')</h6>
                    <p>
                        @switch($store->credit_time)
                            @case("day")
                            @lang('pages_text.time_day')
                            @break

                            @case("week")
                            @lang('pages_text.time_week')
                            @break

                            @case("month")
                            @lang('pages_text.time_month')
                            @break

                            @case("3month")
                            @lang('pages_text.time_3month')
                            @break
                        @endswitch

                    </p>
                </div>
                <!-- /SIDEBAR ITEM -->

                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item author-reputation full">
                    <h4>@lang('pages_text.partner_contact_info')</h4>
                    <hr class="line-separator">
                    <h6>E-Mail</h6>
                    <p>{{$store->email}}</p>
                    <br/>
                    <h6>@lang('stores_page.website')</h6>
                    <p><a target="_blank" href="{{route('redirect.tradedoubler',['id'=>$store->id])}}" class="primary">@lang('pages_text.visit_website')</a></p>
                </div>
                <!-- /SIDEBAR ITEM -->
            </div>
            <!-- /SIDEBAR -->
            <!-- CONTENT -->
            <div class="content right">
                <!-- HEADLINE -->
                @foreach($store->discounts()->where('active',1)->get() as $discount)
                    <div class="headline primary">
                        <h4>{{$discount->category}} : <span>{{number_format( ($discount->cashback - (30/100 * $discount->cashback)) ,2)}}%</span></h4>
                        <div class="clearfix"></div>
                    </div>
                @endforeach
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <!-- HEADLINE -->
                <div class="headline tertiary">
                    <h4>@lang('pages_text.partner_desc') {{$store->name}}</h4>
                    <div class="clearfix"></div>
                </div>
                <!-- PRODUCT LIST -->
                <div class="product-list grid column3-4-wrap">
                    <p>{{$store->store_description}}</p>
                </div>
                <!-- /PRODUCT LIST -->
                <div class="clearfix"></div>
            </div>
            <!-- CONTENT -->
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- /SECTION -->
@endsection
