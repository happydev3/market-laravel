@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.user_notifications') @endsection


@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline buttons primary">
            <h4>@lang('user_panel.notification_title')</h4>
            <a href="{{route('user.notifications.seen')}}" class="button mid-short primary">@lang('user_panel.mark_as_read_btn')</a>
        </div>
        <!-- /HEADLINE -->

        <!-- PROFILE NOTIFICATIONS -->
        <div class="profile-notifications">
            @foreach($notifications as $notification)
                <div class="profile-notification">
                    <div class="profile-notification-date">
                        <p>{{$notification->created_at->format('d/m/y : h:m')}}</p>
                    </div>
                    <div class="profile-notification-body">
                        <p><span>{{$notification->text}}</span></p>
                    </div>
                    <div class="profile-notification-type">
                        @switch($notification->type)
                            @case("general_info")
                                <span class="type-icon icon-bell primary"></span>
                            @break
                            @case("marketing")
                                <span class="type-icon icon-heart primary"></span>
                            @break
                            @case("product_shipped")
                             <span class="type-icon icon-present primary"></span>
                            @break
                        @endswitch
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /PROFILE NOTIFICATIONS -->
        <!-- PAGER -->
            {{$notifications->links()}}
        <!-- /PAGER -->
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection