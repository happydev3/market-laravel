@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.search_page_init') {{\Illuminate\Support\Facades\Input::get('query')}} @lang('page_titles.search_page_end')@endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/jquery.range.css')}}">
@endsection

@section('page_content')
    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap v2">
        <div class="section-headline">
            <h2>@lang('pages_text.search_results_for') {{\Illuminate\Support\Facades\Input::get('query')}} </h2>
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
                    <h4>{{$products->count()}} @lang('products_page.products_found')</h4>
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

            @include('marketplace.components.stores_sidebar')
        </div>
    </div>
    <!-- /SECTION -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/jquery.range.min.js')}}"></script>
    <script src="{{URL::to('js/shop3.js')}}"></script>
@endsection