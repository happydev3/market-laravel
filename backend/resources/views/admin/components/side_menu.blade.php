<!-- BEGIN .app-side -->
<aside class="app-side" id="app-side">
    <!-- BEGIN .side-content -->
    <div class="side-content">
        <!-- BEGIN .side-nav -->
        <nav class="side-nav">
            <!-- BEGIN: side-nav-content -->
            <ul class="unifyMenu" id="unifyMenu">
                <li>
                    <a href="{{route('admin.home')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-laptop_windows"></i>
                        </span>
                        <span class="nav-title">@lang('admin.dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.manage_admins')}}">
							<span class="has-icon">
                                <i class="icon-user-check"></i>
                            </span>
                        <span class="nav-title">@lang('admin.admin_management')</span>
                    </a>
                </li>


                <li>
                    <a href="{{route('admin.users')}}">
							<span class="has-icon">
                                <i class="icon-user"></i>
                            </span>
                        <span class="nav-title">@lang('admin.users')</span>
                    </a>
                </li>

                <li class="menu-header">
                    @lang('admin.stores_management_heading')
                </li>


                <li>
                    <a href="{{route('admin.stores')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-shop2"></i>
                        </span>
                        <span class="nav-title">@lang('admin.stores')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.products')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-gift2"></i>
                        </span>
                        <span class="nav-title">@lang('admin.products')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.store_documents')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-layers"></i>
                        </span>
                        <span class="nav-title">@lang('admin.stores_documents')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.invoices')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-tabs-outline"></i>
                        </span>
                        <span class="nav-title">@lang('admin.invoices')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.cash_invoices')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-tabs-outline"></i>
                        </span>
                        <span class="nav-title">@lang('admin.cash_invoices')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.orders')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-shopping-cart2"></i>
                        </span>
                        <span class="nav-title">@lang('admin.orders')</span>
                    </a>
                </li>

                <li class="menu-header">
                    @lang('admin.finance_area')
                </li>

                <li>
                    <a href="{{route('admin.getters')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-user-check"></i>
                        </span>
                        <span class="nav-title">@lang('admin.getters')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.royalties')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-list4"></i>
                        </span>
                        <span class="nav-title">@lang('admin.royalties')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.cash_status')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-monetization_on"></i>
                        </span>
                        <span class="nav-title">@lang('admin.cash_status')</span>
                    </a>
                </li>



                <li>
                    <a href="{{route('admin.fees')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-user-add"></i>
                        </span>
                        <span class="nav-title">@lang('admin.plattform_fees')</span>
                    </a>
                </li>


                <li>
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-chart-area-outline"></i>
                        </span>
                        <span class="nav-title">@lang('admin.transactions')</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href='{{route('admin.transactions')}}'>@lang('admin.all_transactions')</a>
                        </li>
                        <li>
                            <a href='{{route('admin.online_transactions')}}'>@lang('admin.online_transactions')</a>
                        </li>
                        <li>
                            <a href='{{route('admin.offline_transactions')}}'>@lang('admin.offline_transactions')</a>
                        </li>
                        <li>
                            <a href="{{route('admin.cash_transactions')}}">@lang('admin.cash_transactions')</a>
                        </li>

                        <li>
                            <a href="{{route('admin.td_transactions')}}">TradeDoubler</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="{{route('admin.cashback_requests')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-list"></i>
                        </span>
                        <span class="nav-title">@lang('admin.cashback_requests_side')</span>
                    </a>
                </li>



                <li class="menu-header">
                    @lang('admin.marketng')
                </li>

                <li>
                    <a href="{{route('admin.tradedoubler')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-web"></i>
                        </span>
                        <span class="nav-title">TradeDoubler</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.td_tracking')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-all_inclusive"></i>
                        </span>
                        <span class="nav-title">TradeDoubler Tracking</span>
                    </a>
                </li>


                <li>
                    <a href="{{route('admin.app_banners')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-mobile2"></i>
                        </span>
                        <span class="nav-title">@lang('admin.app_banners')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.search_history')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-search"></i>
                        </span>
                        <span class="nav-title">@lang('admin.search_history')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.newsletter')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-email"></i>
                        </span>
                        <span class="nav-title">@lang('admin.newsletter')</span>
                    </a>
                </li>

                <li class="menu-header">
                    @lang('admin.content_management_heading')
                </li>

                <li>
                    <a href="#" class="has-arrow" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-help"></i>
                        </span>
                        <span class="nav-title">@lang('admin.help_requests')</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href="{{route('admin.store_help')}}">@lang('admin.store_help_request')</a>
                        </li>
                        <li>
                            <a href="{{route('admin.help_users')}}">@lang('admin.user_help_request')</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('admin.faqs')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-question_answer"></i>
                        </span>
                        <span class="nav-title">@lang('admin.faq_editor')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.product_categories')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-shopping-cart"></i>
                        </span>
                        <span class="nav-title">@lang('admin.product_categories')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.store_categories')}}" aria-expanded="false">
                        <span class="has-icon">
                            <i class="icon-shop"></i>
                        </span>
                        <span class="nav-title">@lang('admin.store_categories')</span>
                    </a>
                </li>


            </ul>
            <!-- END: side-nav-content -->
        </nav>
        <!-- END: .side-nav -->
    </div>
    <!-- END: .side-content -->
</aside>
<!-- END: .app-side -->