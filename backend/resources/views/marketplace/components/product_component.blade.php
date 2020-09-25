<div class="product-item column">
    <!-- PRODUCT PREVIEW ACTIONS -->
    <div class="product-preview-actions">
        <!-- PRODUCT PREVIEW IMAGE -->
        <a href="{{route('marketplace.product_detail',['slug' => $product->slug])}}">
            <figure class="product-preview-image">
                    <img src="{{URL::to($product->getWebThumb())}}">
            </figure>
        </a>
        <!-- /PRODUCT PREVIEW IMAGE -->

        <!-- PREVIEW ACTIONS -->
        <div class="preview-actions">
            <!-- PREVIEW ACTION -->
            <div class="preview-action">
                <a href="{{route('marketplace.product_detail',['slug' => $product->slug])}}">
                    <div class="circle tiny primary">
                        <span class="icon-tag"></span>
                    </div>
                </a>
                <a href="{{route('marketplace.product_detail',['slug' => $product->slug])}}">
                    <p>@lang('products_page.go_to_item')</p>
                </a>
            </div>
            <!-- /PREVIEW ACTION -->

            <!-- PREVIEW ACTION -->
            <div class="preview-action">
                <a href="{{route('marketplace.add_favourite',['id'=>$product->id])}}">
                    <div class="circle tiny secondary">
                        <span class="icon-heart"></span>
                    </div>
                </a>
                <a href="{{route('marketplace.add_favourite',['id'=>$product->id])}}">
                    <p>@lang('products_page.add_favourites')</p>
                </a>
            </div>
            <!-- /PREVIEW ACTION -->
        </div>
        <!-- /PREVIEW ACTIONS -->
    </div>
    <!-- /PRODUCT PREVIEW ACTIONS -->

    <!-- PRODUCT INFO -->
    <div class="product-info">
        <a href="{{route('marketplace.product_detail',['slug' => $product->slug])}}">
            <p class="text-header">{{substr($product->title,0,28)}}..</p>
        </a>
        <p class="product-description">{{substr($product->description,0,30)}}...</p>

        <p class="category primary">{{$product->quantity_available}} @lang('pages_text.pcs_available')</p>

        <p class="price"><span>{{$product->currency}}</span>{{number_format($product->price,2)}}</p>
    </div>
    <!-- /PRODUCT INFO -->
    <hr class="line-separator">

    <!-- USER RATING -->
    <div class="user-rating">
        <a href="{{route('marketplace.store_landing',['permalink' => $product->store->permalink])}}">
            <figure class="user-avatar small">
              <img src="{{URL::to($product->store->getStoreLogo())}}" alt="user-avatar">
            </figure>
        </a>
        <a href="{{route('marketplace.store_landing',['permalink' => $product->store->permalink])}}">
            <p class="text-header tiny">{{$product->store->business_name}}</p>
        </a>
    </div>
    <!-- /USER RATING -->
</div>
<!-- /PRODUCT ITEM -->