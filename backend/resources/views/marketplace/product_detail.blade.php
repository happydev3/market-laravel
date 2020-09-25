@extends('marketplace.layouts.main_layout')

@section('page_title') {{$product->title}} @lang('page_titles.single_product_page') @endsection
@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/jssocials.css')}}">
    <link rel="stylesheet" href="{{URL::to('css/jssocials-theme-flat.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection


@section('page_content')


    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>{{$product->title}}</h2>
            <p>Home<span class="separator">/</span>{{App\Models\ProductCategory::where('id',$product->product_category_id)->first()->name}}<span class="separator"></span>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section">
            <!-- SIDEBAR -->
            <div class="sidebar right">
                <!-- SIDEBAR ITEM -->

                <div class="sidebar-item void buttons">
                    <p class="button big dark purchase">
                        <span class="currency">{{number_format($product->price,2)}}</span>
                        <span class="primary">({{number_format($cb_product,2)}}€)</span>
                    </p>
                    @if(($product->sellable()))
                        <a href="{{route('marketplace.checkout',['slug' => $product->slug])}}"  class="button big primary wcart">
                            <span class="icon-present"></span>
                            @lang('pages_text.buy_now')
                        </a>
                    @else
                        <a class="button big primary wcart">
                            <span class="icon-present"></span>
                            @lang('pages_text.product_not_available')
                        </a>
                    @endif
                </div>

                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item author-bio short">
                    <h4>@lang('pages_text.store_details')</h4>
                    <hr class="line-separator">
                    <!-- USER AVATAR -->
                    <a href="{{route('marketplace.store_landing',['permalink'=>$product->store->permalink])}}" class="user-avatar-wrap medium">
                        <figure class="user-avatar medium">
                            <img src="{{URL::to($product->store->getStoreLogo())}}" alt="">
                        </figure>
                    </a>
                    <!-- /USER AVATAR -->
                    <p class="text-header">{{$product->store->business_name}} (-{{$product->store->effectiveCashback()}}%) </p>
                    <p class="text-oneline">{{$product->store->branches->first()->street_address}}<br></p>
                    <br/>
                    <!-- SHARE LINKS -->
                    <!-- /SHARE LINKS -->
                    <div class="clearfix"></div>
                    <a href="{{route('marketplace.store_landing',['permalink'=>$product->store->permalink])}}" class="button mid dark spaced">@lang('pages_text.visit_store')</a>
                </div>
                <!-- /SIDEBAR ITEM -->

                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item author-items-v2">
                    <h4>@lang('pages_text.more_from_store')</h4>
                    <hr class="line-separator">
                    <!-- ITEM PREVIEW -->
                    @foreach($other_from_seller as $other_product)
                        <div class="item-preview">
                            <a href="{{route('marketplace.product_detail',['slug' => $other_product->slug])}}">
                                <figure class="product-preview-image small liquid">
                                    <img src="{{URL::to($other_product->getWebThumb())}}" alt="">
                                </figure>
                            </a>
                            <a href="{{route('marketplace.product_detail',['slug' => $other_product->slug])}}"><p class="text-header small">{{$other_product->title}}</p></a>
                            <p class="price"><span>{{$other_product->currency}}</span>{{number_format($other_product->price,2)}}</p>
                        </div>
                    @endforeach
                </div>
                <!-- /SIDEBAR ITEM -->
            </div>
            <!-- /SIDEBAR -->

            <!-- CONTENT -->
            <div class="content left">
                <!-- POST -->
                <article class="post">
                    <!-- POST IMAGE -->
                    <div class="post-image">
                        <figure class="product-preview-image large liquid">
                            @if($product->multimedia->where('type','image')->first())
                                <img src="{{URL::to($product->multimedia->where('type','image')->first()->url)}}" alt="">
                            @else
                                <img src="{{URL::to('images/defaults/product_big.png')}}">
                            @endif
                        </figure>
                    </div>
                    <!-- /POST IMAGE -->

                    <!-- POST IMAGE SLIDES -->
                    <div class="post-image-slides">
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

                        <!-- IMAGE SLIDES WRAP -->
                        <div class="image-slides-wrap">
                            <!-- IMAGE SLIDES -->
                            <div class="image-slides" data-slide-visible-full="6"
                                 data-slide-visible-small="2"
                                 data-slide-count="9">
                                <!-- IMAGE SLIDE -->
                                @if($product->multimedia->where('type','image')->count() > 0)
                                    <div class="image-slide selected">
                                        <div class="overlay"></div>
                                        <figure class="product-preview-image thumbnail liquid">
                                            <img src="{{URL::to($product->multimedia->where('type','image')->first()->url)}}" alt="">
                                        </figure>
                                    </div>

                                    @foreach($product->multimedia->where('type','image')->all() as $image)
                                        <div class="image-slide">
                                            <div class="overlay"></div>
                                            <figure class="product-preview-image thumbnail liquid">
                                                <img src="{{URL::to($image->url)}}" alt="">
                                            </figure>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="image-slide selected">
                                        <div class="overlay"></div>
                                        <figure class="product-preview-image thumbnail liquid selected">
                                            <img src="{{URL::to('images/defaults/product_big.png')}}" alt="">
                                        </figure>
                                    </div>
                                @endif
                            </div>
                            <!-- IMAGE SLIDES -->
                        </div>
                        <!-- IMAGE SLIDES WRAP -->
                    </div>
                    <!-- /POST IMAGE SLIDES -->

                    <hr class="line-separator">

                    <!-- POST CONTENT -->
                    <div class="post-content">
                        <!-- POST PARAGRAPH -->
                        <div class="post-paragraph">
                            <h3 class="post-title">@lang('pages_text.product_desc')</h3>
                            <p>{{$product->description}}</p>
                        </div>
                        <!-- /POST PARAGRAPH -->

                        <div class="clearfix"></div>
                    </div>
                    <!-- /POST CONTENT -->
                    <hr class="line-separator">
                    <!-- SHARE -->
                    <div class="share-links-wrap">
                        <p class="text-header small">@lang('pages_text.share_on')</p>
                        <!-- SHARE LINKS -->
                        <div id="shareIcons"></div>
                        <!-- /SHARE LINKS -->
                    </div>
                    <!-- /SHARE -->
                </article>
                <!-- /POST -->
            </div>
            <!-- CONTENT -->
        </div>
    </div>
    <!-- /SECTION -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/imgLiquid-min.js')}}"></script>
    <script src="{{URL::to('js/vendor/jquery.xmtab.min.js')}}"></script>
    <script src="{{URL::to('js/vendor/jquery.xmaccordion.min.js')}}"></script>
    <script src="{{URL::to('js/vendor/jquery.xmpiechart.min.js')}}"></script>
    <script src="{{URL::to('js/item-v2.js')}}"></script>
    <script src="{{URL::to('js/image-slides.js')}}"></script>
    <script src="{{URL::to('js/post-tab.js')}}"></script>
    <script src="{{URL::to('js/jssocials.min.js')}}"></script>
    <script>
        $("#shareIcons").jsSocials({
            showLabel: false,
            showCount: false,
            shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp"]
        });
    </script>
@endsection
