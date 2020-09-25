<!-- BEGIN .app-heading -->
<header class="app-header">
    <div class="container-fluid">
        <div class="row gutters">
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-3 col-4">
                <a class="mini-nav-btn" href="#" id="app-side-mini-toggler">
                    <i class="icon-menu5"></i>
                </a>
                <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
                    <i class="icon-chevron-thin-left"></i>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-4">
                <a href="{{route('admin.home')}}" class="logo">
                    <img src="{{URL::to('admin-res/img/logo.png')}}" alt="Unify Admin Dashboard" />
                </a>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-3 col-4">
                <ul class="header-actions">
                    <li class="dropdown">
                        <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                            <img class="avatar" src="{{URL::to('admin-res/img/admin.png')}}" alt="User Thumb" />
                            <span class="user-name">{{Auth::guard('admin')->user()->name}}</span>
                            <i class="icon-chevron-small-down"></i>
                        </a>
                        <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                            <ul class="user-settings-list">
                                <li>
                                    <a href="{{route('admin.locale',['locale' => 'it'])}}">
                                        <img src="{{URL::to('images/dashboard/flag-ita.png')}}">
                                        <p>Italiano</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.locale',['locale' => 'en'])}}">
                                        <img src="{{URL::to('images/dashboard/flag-eng.png')}}">
                                        <p>English</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('marketplace.home') }}">
                                        <img src="{{URL::to('images/freeback_icon.png')}}">
                                        <p>FreeBack</p>
                                    </a>
                                </li>
                            </ul>
                            <div class="logout-btn">
                                <a href="{{ route('admin.logout') }}" class="btn btn-primary">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- END: .app-heading -->