<!-- SIDE MENU -->
<div id="dashboard-options-menu" class="side-menu dashboard left closed">
    <!-- SVG PLUS -->
    <svg class="svg-plus">
        <use xlink:href="#svg-plus"></use>
    </svg>
    <!-- /SVG PLUS -->

    <!-- SIDE MENU HEADER -->
    <div class="side-menu-header">
        <!-- USER QUICKVIEW -->
        <div class="user-quickview">
            <!-- USER AVATAR -->
            <a href="{{route('home')}}">
                <div class="outer-ring">
                    <div class="inner-ring"></div>
                    <figure class="user-avatar">
                        <img src="{{URL::to(Auth::user()->userAvatarLink())}}" alt="avatar">
                    </figure>
                </div>
            </a>
            <!-- /USER AVATAR -->
            <!-- USER INFORMATION -->
            <p class="user-name">{{Auth::user()->name}}</p>
            <p class="user-money">€ {{number_format(Auth::user()->wallet()->first()->available_balance, 2, '.', ',')}}</p>
            <!-- /USER INFORMATION -->
        </div>
        <!-- /USER QUICKVIEW -->
    </div>
    <!-- /SIDE MENU HEADER -->

    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('user_panel.account_side_hint')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect interactive">

        <li class="dropdown-item">
            <a href="{{route('home')}}">
                <span class="sl-icon icon-home"></span>
                @lang('user_panel.dashboard')
            </a>
        </li>


        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('user.notifications')}}">
                <span class="sl-icon icon-star"></span>
                @lang('user_panel.notifications')
            </a>
            <!-- PIN -->
            <span class="pin soft-edged big primary">{{App\Models\UserNotification::where('user_id',Auth::user()->id)->where('seen',0)->count()}}</span>
            <!-- /PIN -->
        </li>
        <!-- /DROPDOWN ITEM -->


        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('user.royality')}}">
                <span class="sl-icon icon-people"></span>
                @lang('user_panel.royality')
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->
    </ul>
    <!-- /DROPDOWN -->

    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('user_panel.money_settings_hint')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect">
        <li class="dropdown-item">
            <a href="{{route('user.wallet')}}">
                <span class="sl-icon icon-wallet"></span>
                @lang('user_panel.wallet')
            </a>
        </li>

        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('user.cashback_request')}}">
                <span class="sl-icon icon-wallet"></span>
                @lang('user_panel.require_cashback')
            </a>
        </li>
    </ul>
    <!-- /DROPDOWN -->



    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('user_panel.help_center_hint')</p>
    <!-- /SIDE MENU TITLE -->


    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect">
        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('user.settings')}}">
                <span class="sl-icon icon-settings"></span>
                @lang('user_panel.account_settings')
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->

        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('user.help')}}">
                <span class="sl-icon icon-question"></span>
                @lang('user_panel.help_center')
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->

    </ul>
    <!-- /DROPDOWN -->

    <a href="{{route('user.logout')}}" class="button medium secondary">@lang('user_panel.logout_btn')</a>
</div>
<!-- /SIDE MENU -->