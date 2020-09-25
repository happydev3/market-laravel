<!-- MAIN MENU -->
<div class="main-menu-wrap">
    <div class="menu-bar">
        <nav>
            <ul class="main-menu">
                <!-- MENU ITEM -->
                <li class="menu-item">
                    <a href="{{route('marketplace.home')}}">@lang('menu.home')</a>
                </li>
                <!-- /MENU ITEM -->
                <!-- MENU ITEM -->
                <li class="menu-item sub">
                    <a href="#">
                        @lang('menu.categories')
                        <!-- SVG ARROW -->
                        <svg class="svg-arrow">
                            <use xlink:href="#svg-arrow"></use>
                        </svg>
                        <!-- /SVG ARROW -->
                    </a>
                    <div class="content-dropdown">
                        <!-- FEATURE LIST BLOCK -->
                        <div class="feature-list-block">
                            <h6 class="feature-list-title">@lang('menu.categories_submenu_main')</h6>
                            <hr class="line-separator">
                            <!-- FEATURE LIST -->
                            <ul class="feature-list">
                                @foreach(App\Models\StoreCategory::where('active',1)->limit(9)->inRandomOrder()->get() as $category)
                                    <li class="feature-list-item">
                                        <a href="{{route('marketplace.store_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- /FEATURE LIST -->

                            <!-- FEATURE LIST -->
                            <ul class="feature-list">
                                @foreach(App\Models\StoreCategory::where('active',1)->limit(9)->inRandomOrder()->get() as $category)
                                    <li class="feature-list-item">
                                        <a href="{{route('marketplace.store_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- /FEATURE LIST -->
                        </div>
                        <!-- /FEATURE LIST BLOCK -->

                        <!-- FEATURE LIST BLOCK -->
                        <div class="feature-list-block">
                            <h6 class="feature-list-title">@lang('menu.categories_submenu_most_w')</h6>
                            <hr class="line-separator">
                            <!-- FEATURE LIST -->
                            <ul class="feature-list">
                                @foreach(App\Models\StoreCategory::where('active',1)->limit(9)->inRandomOrder()->get() as $category)
                                    <li class="feature-list-item">
                                        <a href="{{route('marketplace.store_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- /FEATURE LIST -->
                        </div>
                        <!-- /FEATURE LIST BLOCK -->

                        <!-- FEATURE LIST BLOCK -->
                        <div class="feature-list-block">
                            <h6 class="feature-list-title">@lang('menu.categories_submenu_most_new')</h6>
                            <hr class="line-separator">
                            <!-- FEATURE LIST -->
                            <ul class="feature-list">
                                @foreach(App\Models\StoreCategory::where('active',1)->limit(9)->inRandomOrder()->get() as $category)
                                    <li class="feature-list-item">
                                        <a href="{{route('marketplace.store_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- /FEATURE LIST -->
                        </div>
                        <!-- /FEATURE LIST BLOCK -->
                    </div>
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <a href="{{route('marketplace.stores')}}">@lang('menu.stores')</a>
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <a href="{{route('marketplace.partners')}}">@lang('menu.parner_stores')</a>
                </li>
                <!-- /MENU ITEM -->

                <!-- MENU ITEM -->
                <li class="menu-item">
                    <a href="{{route('marketplace.around')}}">@lang('menu.arround_you')</a>
                </li>
                <!-- /MENU ITEM -->
            </ul>
        </nav>
    
    </div>
</div>
<!-- /MAIN MENU -->