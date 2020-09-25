@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.error_404_title') @endsection


@section('page_content')
            <section class="banner">
                <h1 style="font-size: 55px;"><span>@lang('pages_text.error_404')</span></h1>
                <p style="color:gray"><span>@lang('pages_text.error_404_desc')</span></p>
                <br/>
                <p class="button big primary"><a href="{{route('marketplace.home')}}" style="color:white">@lang('pages_text.error_404_btn')</a></p>
            </section>
@endsection
