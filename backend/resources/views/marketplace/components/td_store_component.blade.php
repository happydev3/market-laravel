<div class="product-item column">
    <!-- PRODUCT PREVIEW ACTIONS -->
    <div class="product-preview-actions">
        <!-- PRODUCT PREVIEW IMAGE -->
        <a href="{{route('marketplace.single_partner',['slug' => $td->slug])}}">
            <figure class="product-preview-image">
                <img src="{{URL::to($td->getWebThumb())}}" alt="{{$td->name}}">
            </figure>
        </a>
        <!-- /PRODUCT PREVIEW IMAGE -->
    </div>
    <!-- /PRODUCT PREVIEW ACTIONS -->

    <!-- PRODUCT INFO -->
    <div class="product-info">
        <a href="{{route('marketplace.single_partner',['slug' => $td->slug])}}">
            <p class="text-header">{{substr($td->name,0,28)}}</p>
        </a>
        <p class="product-description">{{substr($td->store_description,0,35)}}...</p>

        <p class="category primary">Cashback:</p>

        <p class="price"><span>@lang('pages_text.cashback_up_to') </span>@if($td->cashback > 0){{number_format($td->cashback - (30/100 * $td->cashback),2)}}%@else N/A @endif</p>
    </div>
</div>
<!-- /PRODUCT ITEM -->