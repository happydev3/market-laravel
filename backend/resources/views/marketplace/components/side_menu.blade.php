<!-- SIDE MENU -->
<div id="mobile-menu" class="side-menu left closed">
    <!-- SVG PLUS -->
    <svg class="svg-plus">
        <use xlink:href="#svg-plus"></use>
    </svg>
    <!-- /SVG PLUS -->

    <!-- SIDE MENU HEADER -->
    <div class="side-menu-header">
        <figure class="logo small">
            <img src="{{URL::to('images/logo1.png')}}" alt="FreeBack">
        </figure>
    </div>
    <!-- /SIDE MENU HEADER -->

    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('menu.menu_title')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect interactive">
        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('marketplace.home')}}">@lang('menu.home')</a>
        </li>
        <!-- /DROPDOWN ITEM -->

        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('marketplace.stores')}}">@lang('menu.stores')</a>
        </li>
        <!-- /DROPDOWN ITEM -->

        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('marketplace.partners')}}">@lang('menu.parner_stores')</a>
        </li>
        <!-- /DROPDOWN ITEM -->
        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('marketplace.around')}}">@lang('menu.arround_you')</a>
        </li>
        <!-- /DROPDOWN ITEM -->


        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item interactive">
            <a href="#">
                @lang('menu.categories')
                <!-- SVG ARROW -->
                <svg class="svg-arrow">
                    <use xlink:href="#svg-arrow"></use>
                </svg>
                <!-- /SVG ARROW -->
            </a>

            <!-- INNER DROPDOWN -->
            <ul class="inner-dropdown">
                <!-- INNER DROPDOWN ITEM -->
                <li class="inner-dropdown-item">
                    <p>@lang('menu.categories_submenu_main')</p>
                </li>
                <!-- /INNER DROPDOWN ITEM -->
                @foreach(App\Models\StoreCategory::where('active',1)->get() as $category)
                    <li class="inner-dropdown-item">
                        @if($category->name != "Generic")
                            <a href="{{route('marketplace.store_by_cat',['slug'=>$category->slug])}}">{{$category->name}}</a>
                        @endif
                    </li>
                @endforeach
                <!-- /INNER DROPDOWN ITEM -->
            </ul>
            <!-- /INNER DROPDOWN -->
        </li>
        <!-- /DROPDOWN ITEM -->
        <li class="dropdown-item">
            @if(Auth::guard('store')->check())
                <a href="{{route('store.login')}}">@lang('pages_text.store_area')</a>
            @else
                <a href="{{route('store.login')}}">@lang('pages_text.store_area')</a>
            @endif
        </li>
    </ul>
    <!-- /DROPDOWN -->
</div>
<!-- /SIDE MENU -->

<!-- SIDE MENU -->
<div id="account-options-menu" class="side-menu right closed">
    <!-- SVG PLUS -->
    <svg class="svg-plus">
        <use xlink:href="#svg-plus"></use>
    </svg>
    <!-- /SVG PLUS -->

    <!-- SIDE MENU HEADER -->
    <div class="side-menu-header">
        <!-- USER QUICKVIEW -->
        <div class="user-quickview">

            @if(Auth::guard('web')->check())
                <a href="{{route('home')}}">
                    <div class="outer-ring">
                        <div class="inner-ring"></div>
                        <figure class="user-avatar">
                            <img src="{{URL::to(Auth::user()->userAvatarLink())}}">
                        </figure>
                    </div>
                </a>
                <p class="user-name">{{Auth::user()->name}}</p>
                <svg class="svg-arrow">
                    <use xlink:href="#svg-arrow"></use>
                </svg>
                <p class="user-money">€ {{number_format(Auth::user()->wallet()->first()->available_balance, 2, '.', ',')}}</p>
            @else
                <a href="{{route('login')}}">
                    <div class="outer-ring">
                        <div class="inner-ring"></div>
                        <figure class="user-avatar">
                            <img src="{{URL::to('images/defaults/user.jpg')}}">
                        </figure>
                    </div>
                    <p class="user-money">@lang('user_panel.login')</p>
                </a>
            @endif
        </div>
        <!-- /USER QUICKVIEW -->
    </div>
    <!-- /SIDE MENU HEADER -->
    @if(Auth::guard('web')->check())
        <!-- DROPDOWN -->
            <ul class="dropdown dark hover-effect">
                <!-- SIDE MENU TITLE -->
                <p class="side-menu-title">@lang('user_panel.dashboard')</p>
                <!-- /SIDE MENU TITLE -->

                <!-- DROPDOWN -->
                <ul class="dropdown dark hover-effect">
                    <li class="dropdown-item">
                        <a href="{{route('home')}}">@lang('user_panel.dashboard')</a>
                    </li>
                    <li class="dropdown-item">
                        <a href="{{route('user.settings')}}">@lang('user_panel.account_settings')</a>
                    </li>
                   
                    <li class="dropdown-item">
                        <a href="{{route('user.wallet')}}">@lang('user_panel.wallet')</a>
                    </li>

                    <li class="dropdown-item">
                        <a href="#">@lang('user_panel.help_center')</a>
                    </li>
                </ul>
                <!-- /DROPDOWN -->
                <a href="{{route('user.logout')}}" class="button medium secondary">@lang('user_panel.logout_btn')</a>
            </ul>
    @endif

    @if(Auth::guard('store')->check())
        <ul class="dropdown dark hover-effect">
            <p class="side-menu-title">@lang('pages_text.store_area')</p>
            <a href="{{route('store.home')}}" class="button medium secondary">{{ Auth::guard('store')->user()->business_name}}</a>
        </ul>
    @endif
</div>
<!-- /SIDE MENU -->