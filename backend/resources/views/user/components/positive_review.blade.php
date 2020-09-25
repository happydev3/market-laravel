<!-- FORM POPUP -->
<div id="positive-recommendation-popup" class="form-popup new-message mfp-hide">
    <!-- FORM POPUP CONTENT -->
    <div class="form-popup-content">
        <h4 class="popup-title">@lang('pages_text.positive_review')</h4>
        <!-- LINE SEPARATOR -->
        <hr class="line-separator">
        <!-- /LINE SEPARATOR -->
        <div class="recommendation-wrap">
            <div class="recommendation-item">
                <a class="recommendation good">
                    <span class="icon-like"></span>
                </a>
                <p class="text-header small">@lang('pages_text.reccomended')</p>
            </div>
        </div>
            <!-- INPUT CONTAINER -->
        <form method="POST" action="{{route('user.review.submit')}}">
            {{csrf_field()}}
            <input id="positive_ord_id" type="text" name="order_id" style="visibility: hidden">
            <input type="text" name="type" value="positive" style="visibility: hidden">
            <div class="input-container">
                <label for="comment" class="rl-label b-label">@lang('pages_text.your_comment'):</label>
                <textarea name="review" id="positive_review_text" placeholder="@lang('pages_text.your_comment_placeholder')"></textarea>
            </div>
            <!-- /INPUT CONTAINER -->
            <p class="highlighted"><span>Note: @lang('pages_text.review_note')</span> </p>

            <button type="submit" id="review_submit" class="button mid dark">@lang('pages_text.publish_positive_review_btn')</button>
        </form>
    </div>
    <!-- /FORM POPUP CONTENT -->
</div>
<!-- /FORM POPUP -->