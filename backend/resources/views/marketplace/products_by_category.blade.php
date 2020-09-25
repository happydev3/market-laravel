@extends('marketplace.layouts.main_layout')


@section('page_title') @lang('page_titles.products_page') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/jquery.range.css')}}">
@endsection

@section('page_content')
    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap v2">
        <div class="section-headline">
            <h2>@lang('products_page.products_title') in {{$category_name}} </h2>
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
                    <h4>{{$products_count}} @lang('products_page.products_found')</h4>
                    <div class="clearfix"></div>
                </div>
                <!-- /HEADLINE -->

                <!-- PRODUCT SHOWCASE -->
                <div class="product-showcase">
                    <!-- PRODUCT LIST -->
                    <div class="product-list grid column3-4-wrap">
                        @foreach($products as $product)
                            @component('marketplace.components.product_component',['product'=>$product])
                            @endcomponent
                        @endforeach
                    </div>
                    <!-- /PRODUCT LIST -->
                </div>
                <!-- /PRODUCT SHOWCASE -->

                <div class="clearfix"></div>

                {{$products->links()}}
            </div>
            <!-- CONTENT -->

            <!-- SIDEBAR -->
            <div class="sidebar">
                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item">
                    <h4>@lang('products_page.product_categories')</h4>
                    <hr class="line-separator">
                    <form>
                        @foreach($product_categories as  $key=>$category)
                            <input type="checkbox" id="checkbox{{$key}}" name="{{$category->name}}" checked disabled>
                            <label for="checkbox{{$key}}">
                                <span class="checkbox tertiary"><span></span></span>
                                <a style="color:gray" href="{{route('marketplace.products.bycategory',['slug' => $category->slug])}}">{{$category->name}}</a>
                                <span class="quantity">{{$category->products->count()}}</span>
                            </label>
                        @endforeach
                    </form>
                </div>
                <!-- /SIDEBAR ITEM -->
            </div>
            <!-- /SIDEBAR -->
        </div>
    </div>
    <!-- /SECTION -->
@endsection

@section('custom_js')
@endsection
