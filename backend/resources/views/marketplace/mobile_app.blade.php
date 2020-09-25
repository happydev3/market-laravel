@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.mobile_app') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('menu.mobile_app')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">@lang('menu.mobile_app')</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <div class="ht-banner-wrap">

        <!-- HT BANNER -->
        <div class="ht-banner void red">
            <figure class="ht-banner-img2">
                <img src="{{URL::to('images/apps.png')}}" width="100%">
            </figure>
        </div>
        <!-- /HT BANNER -->

        <!-- HT BANNER -->
        <div class="ht-banner">
            <!-- HT BANNER CONTENT -->
            <div class="ht-banner-content">
                <p class="text-header">@lang('pages_text.mobile_app_title')</p>
                <p>@lang('pages_text.mobile_app_desc')</p>
                <a href="#" class="button mid primary wcart"><span class="primary">@lang('pages_text.ios_app')</span></a>
                <a href="#" class="button mid secondary"><span class="primary">@lang('pages_text.android_app')</span></a>
            </div>
            <!-- /HT BANNER CONTENT -->
        </div>
        <!-- /HT BANNER -->



    </div>
@endsection