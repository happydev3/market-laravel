@extends('marketplace.layouts.main_layout')

@section('page_title') {{$store->business_name}} @lang('page_titles.store_reviews') @endsection

@section('custom_css') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>{{$store->business_name}}</h2>
            <p>Home<span class="separator">/</span><span class="current-section">{{$store->business_name}}</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- AUTHOR PROFILE BANNER -->
    <div class="author-profile-banner" style="background-image: url('{{URL::to($store->getStoreBackgroundImg())}}')">
    </div>
    <!-- /AUTHOR PROFILE BANNER -->

    <!-- AUTHOR PROFILE META -->
    <div class="author-profile-meta-wrap">
        <div class="author-profile-meta">
            <!-- AUTHOR PROFILE INFO -->
            <div class="author-profile-info">
                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.cashback')</p>
                    <p>{{number_format($store->discount_rate,2)}} %</p>
                </div>
                <!-- /AUTHOR PROFILE INFO ITEM -->

                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.total_sales')</p>
                    <p>{{$store_sales}}</p>
                </div>
                <!-- /AUTHOR PROFILE INFO ITEM -->

                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.store_type')</p>
                    @if($store->store_type == 'both')
                        <p>@lang('stores_page.store_both')</p>
                    @endif
                    @if($store->store_type == 'physical')
                        <p>@lang('stores_page.store_physical')</p>
                    @endif
                    @if($store->store_type == 'online')
                        <p>@lang('stores_page.store_online')</p>
                    @endif
                </div>
                <!-- /AUTHOR PROFILE INFO ITEM -->

                <!-- AUTHOR PROFILE INFO ITEM -->
                <div class="author-profile-info-item">
                    <p class="text-header">@lang('stores_page.website')</p>
                    @if($store->website != '' or $store->website != null)
                        <p><a target="_blank" href="{{$store->website}}" class="primary">{{$store->website}}</a></p>
                    @else
                        <p>@lang('stores_page.no_website')</p>
                    @endif
                </div>
                <!-- /AUTHOR PROFILE INFO ITEM -->
            </div>
            <!-- /AUTHOR PROFILE INFO -->
        </div>
    </div>
    <!-- /AUTHOR PROFILE META -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section overflowable">
            <!-- SIDEBAR -->
            <div class="sidebar left author-profile">
                <!-- SIDEBAR ITEM -->
                <div class="sidebar-item author-bio">
                    <!-- USER AVATAR -->
                    <a href="#" class="user-avatar-wrap medium">
                        <figure class="user-avatar medium">
                            <img src="{{URL::to($store->getStoreLogo())}}" alt="">
                        </figure>
                    </a>
                    <!-- /USER AVATAR -->
                    <p class="text-header">{{$store->business_name}}</p>
                    <p class="text-oneline">{{$store->street_address}}</p>
                </div>
                <!-- /SIDEBAR ITEM -->

                <!-- DROPDOWN -->
                <ul class="dropdown hover-effect">
                    <li class="dropdown-item active">
                        <a href="{{route('marketplace.store_reviews',['id'=>$store->id])}}">@lang('stores_page.customer_review') ({{$store->reviews->count()}})</a>
                    </li>
                    @if(($store->store_type == 'physical') || ($store->store_type == 'both'))
                        <li class="dropdown-item">
                            <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination={{$store->lat}},{{$store->lng}}">@lang('stores_page.directions')</a>
                        </li>
                    @endif
                </ul>
                <!-- /DROPDOWN -->
            </div>
            <!-- /SIDEBAR -->

            <!-- CONTENT -->
            <div class="content right">
                <!-- HEADLINE -->
                <div class="headline primary">
                    <h4> @lang('pages_text.customer_reviews') ({{$store->reviews->count()}})</h4>
                    <div class="clearfix"></div>
                </div>
                <!-- /HEADLINE -->
                <!-- COMMENTS -->
                <div class="comment-list">
                    @foreach($reviews as $review)
                        <div class="comment-wrap">
                            <figure class="user-avatar medium">
                                <img src="{{URL::to($review->user->userAvatarLink())}}" alt="">
                            </figure>
                            <div class="comment review">
                                <p class="text-header">{{$review->user->name}}</p>
                                <p class="timestamp">{{$review->created_at->format('d/m/y')}}</p>

                                @if($review->type == 'positive')
                                    <p class="recommendation bad tooltip" style="background-color: #00d7b3" title="@lang('pages_text.reccomended')">
                                        <span class="icon-like"></span>
                                    </p>
                                @else
                                    <p class="recommendation good tooltip" title="@lang('pages_text.not_reccomended')">
                                        <span class="icon-dislike"></span>
                                    </p>
                                @endif
                                <p>{{$review->review}}</p>
                            </div>
                        </div>
                        <hr class="line-separator">
                    @endforeach
                    {{$reviews->links()}}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- /SECTION -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/user-board.js')}}"></script>
@endsection