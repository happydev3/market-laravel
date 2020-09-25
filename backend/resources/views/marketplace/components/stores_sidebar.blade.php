
<!-- SIDEBAR -->
<div class="sidebar">
    <!-- SIDEBAR ITEM -->
    <div class="sidebar-item">
        <h4>@lang('pages_text.store_filter')</h4>
        <hr class="line-separator">
        <form>
            @foreach(App\Models\StoreCategory::where('lang','it')->where('active',1)->orderBy('name','ASC')->get() as $category)
                <input type="checkbox" id="{{$category->id}}" name="{{$category->name}}" checked disabled>
                <label for="{{$category->id}}">
                    <span class="checkbox primary primary"><span></span></span>
                    <a style="color:gray" href="{{route('marketplace.store_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                    <span class="quantity">{{$category->stores()->where('active',1)->count()}}</span>
                </label>
            @endforeach
        </form>
    </div>
    <!-- /SIDEBAR ITEM -->

    <!-- SIDEBAR ITEM -->
    <div class="sidebar-item">
        <h4>@lang('pages_text.store_type')</h4>
        <hr class="line-separator">
        <form name="shop_search_form" id="shop_search_form">

            <!-- CHECKBOX -->
            <input type="checkbox" id="ft1" name="online" form="shop_search_form" checked disabled>
            <label for="ft1">
                <span class="checkbox primary"><span></span></span>
                <a href="{{route('marketplace.stores')}}" style="color:gray">@lang('pages_text.store_type_all')</a>
                <span class="quantity">{{App\Models\Store::where('active',1)->count()}}</span>
            </label>
            <!-- /CHECKBOX -->

            <!-- CHECKBOX -->
            <input type="checkbox" id="ft1" name="online" form="shop_search_form" checked disabled>
            <label for="ft1">
                <span class="checkbox primary"><span></span></span>
                <a href="{{route('marketplace.stores.type',['type'=>"online"])}}" style="color:gray">@lang('pages_text.store_type_online')</a>
                <span class="quantity">{{App\Models\Store::where('store_type','online')->count()}}</span>
            </label>
            <!-- /CHECKBOX -->

            <!-- CHECKBOX -->
            <input type="checkbox" id="ft2" name="physical" form="shop_search_form" checked disabled>
            <label for="ft2">
                <span class="checkbox primary"><span></span></span>
                <a href="{{route('marketplace.stores.type',['type'=>"physical"])}}" style="color:gray">@lang('pages_text.store_type_offline')</a>
                <span class="quantity">{{App\Models\Store::where('store_type','physical')->count()}}</span>
            </label>
            <!-- /CHECKBOX -->

            <!-- CHECKBOX -->
            <input type="checkbox" id="ft3" name="both" form="shop_search_form" checked disabled>
            <label for="ft3">
                <span class="checkbox primary"><span></span></span>
                <a href="{{route('marketplace.stores.type',['type'=>'both'])}}" style="color:gray"> @lang('pages_text.store_type_both')</a>
                <span class="quantity">{{App\Models\Store::where('store_type','both')->count()}}</span>
            </label>
            <!-- /CHECKBOX -->
            <!-- /CHECKBOX -->

            <button form="shop_search_form" class="button mid primary">@lang('pages_text.store_filter_button')</button>
        </form>
    </div>
    <!-- /SIDEBAR ITEM -->
</div>
<!-- /SIDEBAR -->
</div>