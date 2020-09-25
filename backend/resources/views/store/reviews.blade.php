@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.store_reviews') @endsection

@section('page_content')
    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline buttons primary">
            <h4>@lang('pages_text.customer_reviews') ({{ $reviewsCount }}) </h4>
        </div>
        <!-- /HEADLINE -->
        <div class="comment-list">
            @foreach($reviews as $review)
                <div class="comment-wrap">
                    <figure class="user-avatar medium">
                        <img src="{{URL::to($review->user->userAvatarLink())}}" alt="">
                    </figure>
                    <div class="comment">
                        <p class="text-header">{{$review->user->name}}</p>
                        <p class="timestamp">{{$review->created_at->format('d/m/20y')}}</p>
                        @if($review->type == "positive")
                            <a href="#" class="report"><span class="type-icon icon-like primary"></span></a>
                        @else
                            <a href="#" class="report"><span class="type-icon icon-dislike tertiary"></span></a>
                        @endif
                        <p>{{$review->review}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $reviews->links() }}
    </div>
@endsection