<!-- FORM POPUP -->
<div id="negative-recommendation-popup" class="form-popup new-message mfp-hide">
    <!-- FORM POPUP CONTENT -->
    <div class="form-popup-content">
        <h4 class="popup-title">@lang('pages_text.positive_review')</h4>
        <!-- LINE SEPARATOR -->
        <hr class="line-separator">
        <!-- /LINE SEPARATOR -->
        <div class="recommendation-wrap">
            <div class="recommendation-item">
                <a href="#" class="recommendation bad">
                    <span class="icon-dislike"></span>
                </a>
                <p class="text-header small">@lang('pages_text.not_reccomended')</p>
            </div>
        </div>

        <form method="POST" action="{{route('user.review.submit')}}">
            {{csrf_field()}}
            <input type="text" name="type" value="negative" style="visibility: hidden">
            <input id="negative_ord_id" type="text" name="order_id" style="visibility: hidden">
            <!-- INPUT CONTAINER -->
            <div class="input-container">
                <label for="comment" class="rl-label b-label">@lang('pages_text.your_comment'):</label>
                <textarea name="review" id="negatve_review_content" placeholder="@lang('pages_text.your_comment_placeholder')"></textarea>
            </div>
            <!-- /INPUT CONTAINER -->
            <p class="highlighted"><span>Note:</span>@lang('pages_text.review_note')</p>

            <button type="submit" id="negative_review_submit" class="button mid dark">@lang('pages_text.publish_positive_review_btn')</button>
        </form>
        </div>
    <!-- /FORM POPUP CONTENT -->
</div>
<!-- /FORM POPUP -->