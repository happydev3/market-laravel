@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.stores_page') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/jquery.range.css')}}">
@endsection


@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('pages_text.partners_on_freeback')</h2>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section">
            <!-- CONTENT -->
            <div class="content">
                <!-- HEADLINE -->
                <div class="headline primary">
                    <h4>{{$storesCount}} @lang('pages_text.stores_found')</h4>
                    <div class="clearfix"></div>
                </div>
                <!-- /HEADLINE -->

                <!-- PRODUCT SHOWCASE -->
                <div class="product-showcase">
                    <!-- PRODUCT LIST -->
                    <div class="product-list grid column3-4-wrap">
                        @if($stores->count() > 0)
                            @foreach($stores as $store)
                                @component('marketplace.components.td_store_component',['td' => $store])
                                @endcomponent
                            @endforeach
                        @endif
                    </div>
                    <!-- /PRODUCT LIST -->
                </div>
                <!-- /PRODUCT SHOWCASE -->

            {{$stores->links()}}
            <!-- /PAGER -->
            </div>
            <!-- CONTENT -->
            @include('marketplace.components.td_stores_sidebar')
        </div>
        <!-- /SECTION -->
    </div>

@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/jquery.range.min.js')}}"></script>
    <script src="{{URL::to('js/shop3.js')}}"></script>
@endsection