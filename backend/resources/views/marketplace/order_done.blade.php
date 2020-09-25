@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.order_done') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('pages_text.order_completed_title')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">@lang('pages_text.order_completed')</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <div class="ht-banner-wrap">
        <!-- HT BANNER -->
        <div class="ht-banner">
            <!-- HT BANNER CONTENT -->
            <div class="ht-banner-content">
                <p class="text-header">@lang('pages_text.thanks_order')</p>
                <p>@lang('pages_text.thanks_order_desc')</p>
                <a href="{{route('marketplace.home')}}" class="button mid dark"><span class="primary">@lang('pages_text.go_home')</span></a>
            </div>
            <!-- /HT BANNER CONTENT -->
        </div>
        <!-- /HT BANNER -->

        <!-- HT BANNER -->
        <div class="ht-banner void red">
            <figure class="ht-banner-img3">
                <img src="{{URL::to('images/okay.png')}}" alt="">
            </figure>
        </div>
        <!-- /HT BANNER -->

    </div>
@endsection