<!-- DASHBOARD HEADER -->
<div class="dashboard-header retracted">

    <!-- DB CLOSE BUTTON -->
    <a href="{{route('marketplace.home')}}" class="db-close-button">
        <img src="{{URL::to('images/dashboard/back-icon.png')}}" alt="back-icon">
    </a>
    <!-- DB CLOSE BUTTON -->

    <!-- DB OPTIONS BUTTON -->
    <div class="db-options-button">
        <img src="{{URL::to('images/dashboard/db-list-right.png')}}" alt="db-list-right">
        <img src="{{URL::to('images/dashboard/close-icon.png')}}" alt="close-icon">
    </div>
    <!-- DB OPTIONS BUTTON -->

    <!-- DASHBOARD HEADER ITEM -->
    <div class="dashboard-header-item title">
        <!-- DB SIDE MENU HANDLER -->
        <div class="db-side-menu-handler">
            <img src="{{URL::to('images/dashboard/db-list-left.png')}}" alt="db-list-left">
        </div>
        <!-- /DB SIDE MENU HANDLER -->
        <h6>@lang('store_panel.dashboard')</h6>
    </div>
    <!-- /DASHBOARD HEADER ITEM -->

    <!-- DASHBOARD HEADER ITEM -->
    <div class="dashboard-header-item form">
        <form class="dashboard-search" action="{{route('marketplace.search')}}">
            <input type="text" name="query" id="search_dashboard" placeholder="@lang('menu.search_bar_placeholder')">
            <input type="image" src="{{URL::to('images/dashboard/search-icon.png')}}" alt="search-icon">
        </form>
    </div>
    <!-- /DASHBOARD HEADER ITEM -->

    <!-- DASHBOARD HEADER ITEM -->
    <div class="dashboard-header-item stats">
        <!-- STATS META -->
        <div class="stats-meta">
            <div class="pie-chart pie-chart1">
                <!-- SVG PLUS -->
                <svg class="svg-plus primary">
                    <use xlink:href="#svg-plus"></use>
                </svg>
                <!-- /SVG PLUS -->
            </div>
            <h6>{{App\Models\StoreVisits::where('store_id',Auth::guard('store')->user()->id)->count()}}</h6>
            <p>@lang('store_panel.store_visits')</p>
        </div>
        <!-- /STATS META -->
    </div>
    <!-- /DASHBOARD HEADER ITEM -->

    <!-- DASHBOARD HEADER ITEM -->
    <div class="dashboard-header-item stats">
        <!-- STATS META -->
        <div class="stats-meta">
            <div class="pie-chart pie-chart2">
                <!-- SVG PLUS -->
                <svg class="svg-plus primary">
                    <use xlink:href="#svg-plus"></use>
                </svg>
                <!-- /SVG PLUS -->
            </div>
            <h6>{{App\Models\Product::where('store_id',Auth::guard('store')->user()->id)->count()}}</h6>
            <p>@lang('store_panel.products_available')</p>
        </div>
        <!-- /STATS META -->
    </div>
    <!-- /DASHBOARD HEADER ITEM -->

    <!-- DASHBOARD HEADER ITEM -->
    <div class="dashboard-header-item stats">
        <!-- STATS META -->
        <div class="stats-meta">
            <div class="pie-chart pie-chart3">
                <!-- SVG PLUS -->
                <svg class="svg-plus primary">
                    <use xlink:href="#svg-plus"></use>
                </svg>
                <!-- /SVG PLUS -->
            </div>
            <h6>{{App\Models\Transaction::where('store_id',Auth::guard('store')->user()->id)->count() + App\Models\CashTransaction::where('store_id',Auth::guard('store')->user()->id)->where('status','accepted')->count() +  App\Models\OnlineTransaction::where('store_id',Auth::guard('store')->user()->id)->count()}}</h6>
            <p>Transazioni</p>
        </div>
        <!-- /STATS META -->
    </div>
    <!-- /DASHBOARD HEADER ITEM -->

    <!-- DASHBOARD HEADER ITEM -->
    <div class="dashboard-header-item back-button">
        <a href="{{route('marketplace.home')}}" class="button mid dark-light">Back to Homepage</a>
    </div>
    <!-- /DASHBOARD HEADER ITEM -->
</div>
<!-- DASHBOARD HEADER -->