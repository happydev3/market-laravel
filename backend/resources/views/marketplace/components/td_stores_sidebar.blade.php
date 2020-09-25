
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
                    <a style="color:gray" href="{{route('marketplace.partners_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                    <span class="quantity">{{$category->externalStores->count()}}</span>
                </label>
            @endforeach
        </form>
    </div>
    <!-- /SIDEBAR ITEM -->
</div>
<!-- /SIDEBAR -->
</div>