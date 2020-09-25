@extends('marketplace.layouts.main_layout')

@section('page_title')@lang('page_titles.user_favourites')@endsection


@section('page_content')
    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('pages_text.favourites_header')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">@lang('pages_text.favourites_header')</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section">
            <!-- PRODUCT SHOWCASE -->
            <div class="product-showcase">
                <!-- PRODUCT LIST -->

                @if($favourites->count() <= 0)

                    <h2 style="color:black">@lang('pages_text.no_favourite_article')</h2>
                    <div class="line-separator"></div>
                    <br/><br/><br/>
                @else
                    <div class="product-list list full">

                    @foreach($favourites as $favourite)
                        <!-- PRODUCT ITEM -->
                            <div class="product-item">
                                <a href="{{ route('marketplace.product_detail',['slug' => $favourite->slug]) }}">
                                    <!-- PRODUCT PREVIEW IMAGE -->
                                    <figure class="product-preview-image small">
                                        <img src="{{URL::to($favourite->getWebThumb())}}" width="70px" height="70px">
                                    </figure>
                                    <!-- /PRODUCT PREVIEW IMAGE -->
                                </a>

                                <!-- PRODUCT INFO -->
                                <div class="product-info">
                                    <a href="{{ route('marketplace.product_detail',['id' => $favourite->id]) }}" target="_blank">
                                        <p class="text-header">{{$favourite->title}}</p>
                                    </a>
                                    <p class="product-description">{{substr($favourite->description,0,22)}}...</p>
                                    <a href="{{ route ('marketplace.products.bycategory',['id' => $favourite->product_category_id]) }}" target="_blank">
                                        <p class="category primary">{{\App\Models\ProductCategory::where('id',$favourite->product_category_id)->first()->name}}</p>
                                    </a>
                                </div>
                                <!-- /PRODUCT INFO -->

                                <!-- AUTHOR DATA -->
                                <div class="author-data">
                                    <!-- USER RATING -->
                                    <div class="user-rating">
                                        <a href="{{route('marketplace.store_landing',['permalink' => $favourite->store->permalink])}}">
                                            <figure class="user-avatar small">
                                                <img src="{{URL::to($favourite->store->getStoreLogo())}}">
                                            </figure>
                                        </a>
                                        <a href="{{route('marketplace.store_landing',['permalink' => $favourite->store->permalink])}}">
                                            <p class="text-header tiny">{{$favourite->store->business_name}} ({{number_format($favourite->store->discount_rate,2)}}%)</p>
                                        </a>
                                    </div>
                                    <!-- /USER RATING -->

                                    <!-- METADATA -->
                                    <div class="metadata">
                                        <!-- META ITEM -->
                                        <div class="meta-item">
                                            <span class="icon-bubble"></span>
                                            <p>{{$favourite->store->reviews->count()}}</p>
                                        </div>
                                        <!-- /META ITEM -->

                                        <!-- META ITEM -->
                                        <div class="meta-item">
                                            <span class="icon-eye"></span>
                                            <p>{{$favourite->store->visits->count()}}</p>
                                        </div>
                                        <!-- /META ITEM -->

                                    </div>
                                    <!-- /METADATA -->
                                </div>
                                <!-- /AUTHOR DATA -->

                                <!-- ITEM METADATA -->
                                <div class="item-metadata">
                                    <p class="text-header tiny">@lang('pages_text.product_desc'): <span>{{ substr($favourite->description,0, 180) }}...</span></p>
                                </div>
                                <!-- ITEM METADATA -->

                                <!-- AUTHOR DATA REPUTATION -->
                                <div class="author-data-reputation">
                                    <p class="text-header tiny">@lang('pages_text.customer_reviews')</p>
                                    <ul class="rating">
                                        <p align="center">{{$favourite->store->reviews->count()}}</p>
                                    </ul>
                                </div>
                                <!-- /AUTHOR DATA REPUTATION -->

                                <!-- ITEM ACTIONS -->
                                <div class="item-actions">
                                    <a href="{{route('marketplace.remove_favourite',['id' => $favourite->id])}}" class="tooltip" title="@lang('pages_text.remove_favourite')">
                                        <div class="circle tiny">
                                            <span class="icon-trash"></span>
                                        </div>
                                    </a>
                                </div>
                                <!-- /ITEM ACTIONS -->

                                <!-- PRICE INFO -->
                                <div class="price-info">
                                    <p class="price medium"><span>{{$favourite->currency}}</span>{{number_format($favourite->price,2)}}</p>
                                </div>
                                <!-- /PRICE INFO -->
                            </div>
                            <!-- /PRODUCT ITEM -->
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="clearfix"></div>

            <!-- PAGER -->
            <div class="pager primary">
                {{$favourites->links()}}
            </div>
            <!-- /PAGER -->
        </div>
    </div>
    <!-- /SECTION -->
@endsection


