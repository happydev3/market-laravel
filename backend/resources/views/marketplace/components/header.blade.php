<!-- HEADER -->
<div class="header-wrap">
    <header>
        <!-- LOGO -->
        <a href="{{route('marketplace.home')}}">
            <figure class="logo">
                <img src="{{URL::to('images/logo1.png')}}" alt="FreeBack Logo">
            </figure>
        </a>
        <!-- /LOGO -->

        <!-- MOBILE MENU HANDLER -->
        <div class="mobile-menu-handler left primary">
            <img src="{{URL::to('images/pull-icon.png')}}" alt="pull-icon">
        </div>
        <!-- /MOBILE MENU HANDLER -->

        <!-- LOGO MOBILE -->
        <a href="{{route('marketplace.home')}}">
            <figure class="logo-mobile">
                <img src="{{URL::to('images/logo_mobile.png')}}" alt="Freeback Icon">
            </figure>
        </a>
        <!-- /LOGO MOBILE -->

        <!-- MOBILE ACCOUNT OPTIONS HANDLER -->
        <div class="mobile-account-options-handler right secondary">
            <span class="icon-user"></span>
        </div>
        <!-- /MOBILE ACCOUNT OPTIONS HANDLER -->

        <!-- USER BOARD -->
        <div class="user-board">
            <!-- USER QUICKVIEW -->
            <div class="user-quickview">
               @if(Auth::guard('web')->check())
                    <a href="{{route('home')}}">
                        <div class="outer-ring">
                            <div class="inner-ring"></div>
                            <figure class="user-avatar">
                               <img src="{{URL::to(Auth::guard('web')->user()->userAvatarLink())}}" alt="avatar">
                            </figure>
                        </div>
                    </a>
                    <p class="user-name">{{Auth::guard('web')->user()->name}}</p>
                    <svg class="svg-arrow">
                        <use xlink:href="#svg-arrow"></use>
                    </svg>
                    <p class="user-money">€ {{number_format(Auth::guard('web')->user()->wallet()->first()->available_balance, 2, '.', ',')}}</p>
                    <!-- DROPDOWN -->
                    <ul class="dropdown small hover-effect closed">
                        <li class="dropdown-item">
                            <div class="dropdown-triangle"></div>
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

                        <li class="dropdown-item">
                            <a href="{{route('user.logout')}}">@lang('user_panel.logout_btn')</a>
                        </li>
                    </ul>
                    <!-- /DROPDOWN -->
               @else
                    <a href="{{route('login')}}">
                        <div class="outer-ring">
                            <div class="inner-ring"></div>
                            <figure class="user-avatar">
                                <img src="{{URL::to('images/defaults/user.jpg')}}" alt="avatar">
                            </figure>
                        </div>
                        <p class="user-money">@lang('user_panel.login')</p>
                    </a>
               @endif
            </div>
            <!-- /USER QUICKVIEW -->
           
            <!-- ACCOUNT ACTIONS -->
            <div class="account-actions">
                @if(Auth::guard('store')->check())
                    <a href="{{route('store.login')}}" class="button secondary">@lang('pages_text.store_area')</a>
                @else
                    <a href="{{route('store.login')}}" class="button secondary">@lang('pages_text.store_area')</a>
                @endif
                @if(!Auth::guard('web')->check())
                        <a href="{{route('login')}}" class="button secondary">@lang('pages_text.user_area')</a>
                @endif
            </div>
            <!-- /ACCOUNT ACTIONS -->
        </div>
        <!-- /USER BOARD -->
    </header>
</div>
<!-- /HEADER -->
