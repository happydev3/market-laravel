@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.stores_page') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/jquery.range.css')}}">
@endsection


@section('page_content')

    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('pages_text.stores_by_cat_header') {{$category_name}}</h2>
        </div>
    </div>

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section">
            <div class="content">

                <div class="headline primary">
                    <h4>{{$stores->count()}} @lang('pages_text.stores_found')</h4>
                    <div class="clearfix"></div>
                </div>

                <div class="product-showcase">
                    <div class="product-list grid column3-4-wrap">
                        @if($stores->count() > 0)
                            @foreach($stores as $store)
                                @component('marketplace.components.td_store_component',['td' => $store])
                                @endcomponent
                            @endforeach
                        @endif
                    </div>
                </div>

                {{$stores->links()}}

            </div>
            @include('marketplace.components.td_stores_sidebar')
        </div>
    </div>

@endsection
