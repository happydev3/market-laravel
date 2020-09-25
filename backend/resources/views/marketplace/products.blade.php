@extends('marketplace.layouts.main_layout')


@section('page_title') @lang('page_titles.products_page') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/jquery.range.css')}}">
@endsection

@section('page_content')
    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap v2">
        <div class="section-headline">
            <h2>@lang('products_page.products_title')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">@lang('products_page.products_title')</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section">
            <!-- CONTENT -->
            <div class="content">
                <!-- HEADLINE -->
                <div class="headline tertiary">
                    <h4>{{$products_count}} @lang('products_page.products_found')  @if((app('request')->input('lower_price')) && (app('request')->input('higher_price')))  @lang('pages_text.between')  {{app('request')->input('lower_price')}}€  @lang('pages_text.and')  {{app('request')->input('higher_price')}}€  @endif  </h4>
                    <div class="clearfix"></div>
                </div>
                <!-- /HEADLINE -->

                <!-- PRODUCT SHOWCASE -->
                <div class="product-showcase">
                    <div class="product-list grid column3-4-wrap">
                        @foreach($products as $product)
                            @component('marketplace.components.product_component',['product'=>$product])
                            @endcomponent
                        @endforeach
                    </div>
                </div>
                <!-- /PRODUCT SHOWCASE -->
                <p> {{$products->links('vendor.pagination.marketplace_paginator')}}</p>
                <div class="clearfix"></div>
            </div>
            <!-- CONTENT -->


            <!-- SIDEBAR -->
            <div class="sidebar">
                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item">
                    <h4>@lang('products_page.product_categories')</h4>
                    <hr class="line-separator">
                        @foreach($product_categories as  $key=>$category)
                            <input type="checkbox" id="checkbox{{$key}}" name="{{$category->name}}" checked disabled>
                            <label for="checkbox{{$key}}">
                                <span class="checkbox tertiary"><span></span></span>
                                    <a style="color:gray" href="{{route('marketplace.products.bycategory',['slug' => $category->slug])}}">{{$category->name}}</a>
                                <span class="quantity">{{$category->products->count()}}</span>
                            </label>
                        @endforeach
                </div>
                <!-- /SIDEBAR ITEM -->

                <form id="shop_search_form" name="shop_search_form">
                    <div class="sidebar-item range-feature">
                        <h4>@lang('products_page.price_range')</h4>
                        <hr class="line-separator spaced">
                        <input type="hidden" name="lower_price" id="lower_price">
                        <input type="hidden" name="higher_price" id="higher_price">
                        <input type="hidden" class="price-range-slider-euro tertiary " value="500" form="shop_search_form">
                        <button form="shop_search_form"  id="range_filter_btn" class="button mid tertiary">@lang('products_page.update_search')</button>
                    </div>
                </form>
            </div>
            <!-- /SIDEBAR -->
        </div>
    </div>
    <!-- /SECTION -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/jquery.range.min.js')}}"></script>
    <script src="{{URL::to('js/shop3.js')}}"></script>
    <script>
        (function($) {

            var lowLimit = 0;
            var highLimit = 0;

            /*-----------
                RANGE
            -----------*/
            $('.price-range-slider-euro').jRange({
                from: 1,
                to: 999,
                step: 1,
                format: '%s€',
                width: 242,
                showLabels: true,
                showScale: false,
                isRange : true,
                onstatechange : function(value){
                    var prices = value.split(',');
                    $('#lower_price').val(prices[0]);
                    $('#higher_price').val(prices[1]);
                },
                theme: "theme-edragon tertiary",
            });
        })(jQuery);

    </script>
@endsection
