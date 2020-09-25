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
            <a href="{{route('store.home')}}">
                <div class="outer-ring">
                    <div class="inner-ring"></div>
                    <figure class="user-avatar">
                            <img src="{{URL::to(Auth::guard('store')->user()->getStoreLogo())}}" alt="avatar">
                    </figure>
                </div>
            </a>
            <!-- /USER AVATAR -->
            <!-- USER INFORMATION -->
            <p class="user-name">Online</p>
            <p class="user-money">{{Auth::guard('store')->user()->business_name}}</p>
            <!-- /USER INFORMATION -->
        </div>
    </div>
    <!-- /SIDE MENU HEADER -->

    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('store_panel.store_management_hint')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect interactive">

        <li class="dropdown-item">
            <a href="{{route('store.home')}}">
                <span class="sl-icon icon-home"></span>
                @lang('store_panel.dashboard')
            </a>
        </li>

        <li class="dropdown-item">
            <a href="{{route('store.approve_cash')}}">
                <span class="sl-icon icon-lock"></span>
                @lang('store_panel.cash_transactions')
            </a>
        </li>

        <li class="dropdown-item interactive">
            <a href="#">
                <span class="sl-icon icon-settings"></span>
                @lang('store_panel.store_management')

                <svg class="svg-arrow">
                    <use xlink:href="#svg-arrow"></use>
                </svg>
            </a>

            <!-- INNER DROPDOWN -->
            <ul class="inner-dropdown">
                <!-- INNER DROPDOWN ITEM -->
                <li class="inner-dropdown-item">
                    <a href="{{route('store.settings')}}">@lang('store_panel.store_info')</a>
                </li>
                <!-- /INNER DROPDOWN ITEM -->

                <!-- INNER DROPDOWN ITEM -->
                <li class="inner-dropdown-item">
                    <a href="{{route('store.address')}}">@lang('store_panel.store_address')</a>
                </li>
                <!-- /INNER DROPDOWN ITEM -->
            </ul>
            <!-- INNER DROPDOWN -->
        </li>
        <!-- /DROPDOWN ITEM -->

        <li class="dropdown-item">
            <a href="{{route('store.discount_rate')}}">
                <span class="sl-icon icon-equalizer"></span>
                @lang('store_panel.discount_rate')
            </a>
        </li>

        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('store.reviews')}}">
                <span class="sl-icon icon-like"></span>
                @lang('store_panel.store_reviews')
            </a>
            <!-- PIN -->
            <span class="pin soft-edged big primary">{{Auth::guard('store')->user()->reviews->count()}}</span>
            <!-- /PIN -->
        </li>
        <!-- /DROPDOWN ITEM -->

        <li class="dropdown-item">
            <a href="{{route('store.wallet')}}">
                <span class="sl-icon icon-wallet"></span>
                @lang('user_panel.wallet')
            </a>
        </li>
    </ul>
    <!-- /DROPDOWN -->

    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('store_panel.moneybox_hint')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect">

        <!--DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('store.royality')}}">
                <span class="sl-icon icon-user-following"></span>
                @lang('user_panel.royality')
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->
    </ul>
    <!-- /DROPDOWN -->

    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('store_panel.administration_hint')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect">
        <!-- DROPDOWN ITEM -->
        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('store.cash_invoices')}}">
                <span class="sl-icon icon-docs"></span>
                @lang('store_panel.cash_invoices')
                <span class="pin soft-edged big primary">{{\App\Models\CashInvoice::where('store_id',Auth::guard('store')->user()->id)->where('valid',1)->count()}}</span>
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->


        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('store.documents')}}">
                <span class="sl-icon icon-doc"></span>
                @lang('store_panel.store_documents')
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->
    </ul>
    <!-- /DROPDOWN -->





    <!-- SIDE MENU TITLE -->
    <p class="side-menu-title">@lang('user_panel.help_center_hint')</p>
    <!-- /SIDE MENU TITLE -->

    <!-- DROPDOWN -->
    <ul class="dropdown dark hover-effect">
        <!-- DROPDOWN ITEM -->
        <li class="dropdown-item">
            <a href="{{route('store.help')}}">
                <span class="sl-icon icon-question"></span>
                @lang('store_panel.help_center')
            </a>
        </li>
        <!-- /DROPDOWN ITEM -->
    </ul>
    <!-- /DROPDOWN -->

    <a href="{{route('store.logout')}}" class="button medium secondary">@lang('user_panel.logout_btn')</a>
</div>
<!-- /SIDE MENU -->