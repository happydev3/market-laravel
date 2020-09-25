<div class="product-item column">
    <div class="product-preview-actions">
        <a href="{{route('marketplace.store_landing', ['permalink' => $store->permalink])}}">
            <figure class="product-preview-image">
                <img src="{{URL::to($store->getStoreFrontImg())}}" alt="product-image">
            </figure>
        </a>
    </div>
    <div class="product-info">
        <a href="{{route('marketplace.store_landing', ['permalink' => $store->permalink])}}">
            <p class="text-header">{{substr($store->business_name,0,25)}}..({{ $store->effectiveCashback()}}%)</p>
        </a>

        <p class="product-description">{{substr($store->getAddress()->street_address,0,35)}}</p>
        <p class="category primary">{{$store->store_category->name}}</p>
    </div>
</div>