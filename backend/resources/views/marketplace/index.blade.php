@extends('marketplace.layouts.main_layout')

@section('page_title')@lang('page_titles.home_page')@endsection
@section('page_content')

    <!-- BANNER -->
    <div class="banner-wrap">
        <section class="banner">
            <h5>@lang('pages_text.home_hero_welcome')</h5>
            <h1>@lang('pages_text.home_hero_2')</h1>
            <p>@lang('pages_text.home_hero_desc')</p>
            <img src="{{URL::to('images/top_items.png')}}" alt="banner-img">

            <!-- SEARCH WIDGET -->
            <div class="search-widget">
                <form class="search-widget-form" action="{{route('marketplace.search')}}">
                    <input type="text" name="query" placeholder="@lang('pages_text.search_form_placeholder')">
                    <label for="categories" class="select-block">
                        <select name="category" id="categories">
                            <option value="0">@lang('pages_text.search_form_all_categories')</option>
                             @foreach($store_categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                             @endforeach
                        </select>
                        <!-- SVG ARROW -->
                        <svg class="svg-arrow">
                            <use xlink:href="#svg-arrow"></use>
                        </svg>
                        <!-- /SVG ARROW -->
                    </label>
                    <button class="button medium dark">@lang('pages_text.search_form_btn')</button>
                </form>
            </div>
            <!-- /SEARCH WIDGET -->
        </section>
    </div>
    <!-- /BANNER -->


    <div class="clearfix"></div>

    <!-- PRODUCT SIDESHOW -->
    <div id="product-sideshow-wrap">

        <div id="product-sideshow">
            <!-- PRODUCT SHOWCASE -->
            @if(count($tradeDoubler) > 0)
                <div class="product-showcase">
                    <!-- HEADLINE -->
                    <div class="headline">
                        <h4>@lang('menu.parner_stores')</h4>
                        <!-- SLIDE CONTROLS -->
                        <div class="slide-control-wrap">
                            <div class="slide-control left">
                                <!-- SVG ARROW -->
                                <svg class="svg-arrow">
                                    <use xlink:href="#svg-arrow"></use>
                                </svg>
                                <!-- /SVG ARROW -->
                            </div>

                            <div class="slide-control right">
                                <!-- SVG ARROW -->
                                <svg class="svg-arrow">
                                    <use xlink:href="#svg-arrow"></use>
                                </svg>
                                <!-- /SVG ARROW -->
                            </div>
                        </div>
                        <!-- /SLIDE CONTROLS -->
                    </div>
                    <!-- /HEADLINE -->

                    <!-- PRODUCT LIST -->
                    <div id="pl-6" class="product-list grid column4-wrap owl-carousel">
                        @foreach($tradeDoubler as $td)
                            @component('marketplace.components.td_store_component',['td'=>$td])
                            @endcomponent
                        @endforeach
                    </div>
                    <!-- PRODUCT LIST -->
                </div>
                <!-- PRODUCT SHOWCASE -->
            @endif

            <!-- PRODUCT SHOWCASE -->
            <div class="product-showcase">
                <!-- HEADLINE -->
                <div class="headline primary">
                    <h4>@lang('menu.stores')</h4>
                    <!-- SLIDE CONTROLS -->
                    <div class="slide-control-wrap">
                        <div class="slide-control left">
                            <!-- SVG ARROW -->
                            <svg class="svg-arrow">
                                <use xlink:href="#svg-arrow"></use>
                            </svg>
                            <!-- /SVG ARROW -->
                        </div>

                        <div class="slide-control right">
                            <!-- SVG ARROW -->
                            <svg class="svg-arrow">
                                <use xlink:href="#svg-arrow"></use>
                            </svg>
                            <!-- /SVG ARROW -->
                        </div>
                    </div>
                    <!-- /SLIDE CONTROLS -->
                </div>
                <!-- /HEADLINE -->

                <!-- PRODUCT LIST -->
                <div id="pl-1" class="product-list grid column4-wrap owl-carousel">
                    @foreach($premiumStores as $premiumStore)
                        @component('marketplace.components.store_component',['store'=>$premiumStore])
                        @endcomponent
                    @endforeach
                </div>
                <!-- /PRODUCT LIST -->
            </div>
            <!-- /PRODUCT SHOWCASE -->
        </div>
    </div>
    <!-- /PRODUCTS SIDESHOW -->


    @if(!Auth::check())
        <!-- SERVICES -->
        <div id="services-wrap">
            <section id="services">
                <!-- SERVICE LIST -->
                <div class="service-list column4-wrap">
                    <!-- SERVICE ITEM -->
                    <div class="service-item column">
                        <div class="circle medium gradient"></div>
                        <div class="circle white-cover"></div>
                        <div class="circle dark">
                            <a href="{{route('register')}}"><span class="icon-present"></span></a>
                        </div>
                        <h3>@lang('pages_text.home_adv1_title')</h3>
                        <p>@lang('pages_text.home_adv1_desc')</p>
                    </div>
                    <!-- /SERVICE ITEM -->

                    <!-- SERVICE ITEM -->
                    <div class="service-item column">
                        <div class="circle medium gradient"></div>
                        <div class="circle white-cover"></div>
                        <div class="circle dark">
                            <span class="icon-lock"></span>
                        </div>
                        <h3>@lang('pages_text.home_adv2_title')</h3>
                        <p>@lang('pages_text.home_adv2_desc')</p>
                    </div>
                    <!-- /SERVICE ITEM -->

                    <!-- SERVICE ITEM -->
                    <div class="service-item column">
                        <div class="circle medium gradient"></div>
                        <div class="circle white-cover"></div>
                        <div class="circle dark">
                            <span class="icon-like"></span>
                        </div>
                        <h3>@lang('pages_text.home_adv3_title')</h3>
                        <p>@lang('pages_text.home_adv3_desc')</p>
                    </div>
                    <!-- /SERVICE ITEM -->

                    <!-- SERVICE ITEM -->
                    <div class="service-item column">
                        <div class="circle medium gradient"></div>
                        <div class="circle white-cover"></div>
                        <div class="circle dark">
                            <span class="icon-diamond"></span>
                        </div>
                        <h3>@lang('pages_text.home_adv4_title')</h3>
                        <p>@lang('pages_text.home_adv4_desc')</p>
                    </div>
                    <!-- /SERVICE ITEM -->
                </div>
                <!-- /SERVICE LIST -->
                <div class="clearfix"></div>
            </section>
        </div>
        <!-- /SERVICES -->

        <!-- PROMO -->
        <div class="promo-banner dark left">
            <span class="icon-wallet"></span>
            <h5>@lang('pages_text.become_vendor_pre')</h5>
            <h1>@lang('pages_text.become_vendor_desc')</h1>
            <a href="{{route('store.register')}}" class="button medium primary">@lang('pages_text.become_vendor_btn')</a>
        </div>
        <!-- /PROMO -->

        <!-- PROMO -->
        <div class="promo-banner secondary right">
            <span class="icon-tag"></span>
            <h5>@lang('pages_text.become_user_pre')</h5>
            <h1>@lang('pages_text.become_user_desc')</h1>
            <a href="{{route('register')}}" class="button medium dark">@lang('pages_text.become_user_btn')</a>
        </div>
        <!-- /PROMO -->
    @endif

@endsection

@section('custom_js')
@endsection