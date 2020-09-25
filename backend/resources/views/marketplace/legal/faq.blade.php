@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.faq_page') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('info_pages.faq')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">FAQ</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <div class="section-wrap">
        <div class="section">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item">
                <h4>@lang('info_pages.faq_panel_title')</h4>
                <hr class="line-separator">
                <div class="alert-boxes-preview-description">
                    @foreach($faqs as $faq)
                        <p class="text-header small">{{$faq->question}}</p> <br/>
                        <p>{{$faq->answer}}</p> <br/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>






@endsection
