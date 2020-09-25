@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.manage_products') @endsection

@section('page_content')
        <!-- HEADLINE -->
        <div class="headline filter primary">
            <h4>@lang('store_panel.manage_products_panel_title') ({{ count($products) }})</h4>
            <a href="{{route('store.new_product')}}" class="button small primary">@lang('store_panel.add_product_panel_btn')</a>
        </div>
        <!-- /HEADLINE -->
        <!-- PRODUCT LIST -->
        <div class="product-list grid column4-wrap">
            <!-- PRODUCT ITEM -->
            <div class="product-item upload-new column">
                <!-- PRODUCT PREVIEW ACTIONS -->
                <div class="product-preview-actions">
                    <!-- PRODUCT PREVIEW IMAGE -->
                    <figure class="product-preview-image">
                        <a href="{{route('store.new_product')}}"><img src="{{URL::to('images/dashboard/uploadnew-bg.jpg')}}"></a>
                    </figure>
                    <!-- /PRODUCT PREVIEW IMAGE -->
                </div>
                <!-- /PRODUCT PREVIEW ACTIONS -->

                <!-- PRODUCT INFO -->
                <div class="product-info">
                    <p class="text-header"> <a href="{{route('store.new_product')}}">@lang('store_panel.add_product_panel_btn')</a></p>
                    <p class="description">@lang('store_panel.add_product_btn_desc')</p>
                </div>
                <!-- /PRODUCT INFO -->
            </div>

            @foreach($products as $product)
                <div class="product-item column">
                    <!-- PRODUCT PREVIEW ACTIONS -->
                    <div class="product-preview-actions">
                        <!-- PRODUCT PREVIEW IMAGE -->
                        @if($product->multimedia->where('type','web_thumb')->count() > 0)
                            <figure class="product-preview-image">
                                <img src="{{URL::to($product->multimedia->where('type','web_thumb')->first()->url)}}">
                            </figure>
                        @else
                            <figure class="product-preview-image">
                                <img src="{{URL::to('images/items/no-photo-item.png')}}" alt="">
                            </figure>
                        @endif

                        @if($product->loaded_by == "vendor")
                        <!-- PRODUCT SETTINGS -->
                            <div class="product-settings primary dropdown-handle">
                                <span class="sl-icon icon-settings"></span>
                            </div>
                            <!-- /PRODUCT SETTINGS -->

                            @if($product->active == 0)
                            <!-- DROPDOWN -->
                                <ul class="dropdown small hover-effect closed">
                                    <li class="dropdown-item">
                                        <!-- DP TRIANGLE -->
                                        <div class="dp-triangle"></div>
                                        <!-- DP TRIANGLE -->
                                        <a href="{{ route('store.product_enable',['id' => $product->id]) }}">@lang('store_panel.enable_product')</a>
                                    </li>
                                </ul>
                                <!-- /DROPDOWN -->
                            @else
                            <!-- DROPDOWN -->
                                <ul class="dropdown small hover-effect closed">
                                    <li class="dropdown-item">
                                        <!-- DP TRIANGLE -->
                                        <div class="dp-triangle"></div>
                                        <!-- DP TRIANGLE -->
                                        <a href="{{ route('store.product.edit',['id' => $product->id]) }}">@lang('store_panel.edit_product')</a>
                                    </li>

                                    <li class="dropdown-item">
                                        <div class="dp-triangle"></div>
                                        <a href="{{ route('store.edit_product_multimedia',['id'=>$product->id]) }}">@lang('store_panel.product_edit_images')</a>
                                    </li>

                                    <li class="dropdown-item">
                                        <div class="dp-triangle"></div>
                                        <a  href="{{ route('store.product.disable',['id'=>$product->id]) }}">@lang('store_panel.disable_product')</a>
                                    </li>
                                </ul>
                                <!-- /DROPDOWN -->
                            @endif
                        @endif
                    </div>
                    <!-- /PRODUCT PREVIEW ACTIONS -->
                    <!-- PRODUCT INFO -->
                    <div class="product-info">
                        <a href="{{ route('marketplace.product_detail',['slug'=>$product->slug]) }}" target="_blank">
                            <p class="text-header">{{$product->title}}</p>
                        </a>
                        <p class="product-description">@if($product->active == 1) {{substr($product->title,0,18)}}... @else <span style="color:red">@lang('store_panel.product_disabled')</span> @endif</span>
                        <p clasS="product-description">@lang('store_panel.product_quantity'): {{$product->quantity_available}}</p>
                        <p class="category primary">{{App\Models\ProductCategory::where('id',$product->product_category_id)->first()->name}}</p>
                        <p class="price"><span>{{$product->currency}}</span>{{$product->price}}</p>
                    </div>

                    <!-- USER RATING -->
                    <div class="user-rating">
                        <a href="{{route('marketplace.product_detail',['slug'=>$product->slug])}}" target="_blank">
                            <figure class="user-avatar small">
                                <img src="{{URL::to('images/view.png')}}">
                            </figure>
                        </a>
                        <a href="{{route('marketplace.product_detail',['slug'=>$product->slug])}}" target="_blank">
                            <p class="text-header tiny">@lang('store_panel.visit_product')</p>
                        </a>
                    </div>
                    <!-- /USER RATING -->
                </div>
            @endforeach
            <div class="clearfix"></div>
            {{$products->links('vendor.pagination.default')}}
        </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('js/dashboard-manageitems.js')}}"></script>
@endsection