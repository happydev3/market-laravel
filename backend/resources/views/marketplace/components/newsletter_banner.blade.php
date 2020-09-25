<!-- SUBSCRIBE BANNER -->
<div id="subscribe-banner-wrap">
    <div id="subscribe-banner">
        <!-- SUBSCRIBE CONTENT -->
        <div class="subscribe-content">
            <!-- SUBSCRIBE HEADER -->
            <div class="subscribe-header">
                <figure>
                    <img src="{{URL::to('images/news_icon.png')}}" alt="subscribe-icon">
                </figure>
                <p class="subscribe-title">@lang('pages_text.newsletter_subscribe')</p>
                <p>@lang('pages_text.newsletter_after')</p>
            </div>
            <!-- /SUBSCRIBE HEADER -->

            <!-- SUBSCRIBE FORM -->
            <form class="subscribe-form">
                <input type="text" name="subscribe_email" id="subscribe_email" placeholder="@lang('pages_text.newlsetter_placeholder')">
                <button class="button medium dark" id="newsletterSubscrieBtn">@lang('pages_text.newsletter_btn')</button>
                <label style="color:white;" id="tnxMsg">@lang('pages_text.newsletter_thanks')</label>
            </form>
            <!-- /SUBSCRIBE FORM -->
        </div>
        <!-- /SUBSCRIBE CONTENT -->
    </div>
</div>
<!-- /SUBSCRIBE BANNER -->
