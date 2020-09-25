@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.order_error_online') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('pages_text.error_payment')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">@lang('pages_text.error_payment')</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <div class="ht-banner-wrap">
        <!-- HT BANNER -->
        <div class="ht-banner">
            <!-- HT BANNER CONTENT -->
            <div class="ht-banner-content">
                <p class="text-header">@lang('pages_text.error_payment')</p>
                <p>@lang('pages_text.error_payment_desc')</p>
                <a href="{{route('marketplace.home')}}" class="button mid dark"><span class="primary">@lang('pages_text.go_home')</span></a>
            </div>
            <!-- /HT BANNER CONTENT -->
        </div>
        <!-- /HT BANNER -->

        <!-- HT BANNER -->
        <div class="ht-banner void red">
            <figure class="ht-banner-img3">
                <img src="{{URL::to('images/sad.png')}}" alt="">
            </figure>
        </div>
        <!-- /HT BANNER -->

    </div>
@endsection