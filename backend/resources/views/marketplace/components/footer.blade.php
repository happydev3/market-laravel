<!-- FOOTER -->
<footer>
    <!-- FOOTER TOP -->
    <div id="footer-top-wrap">
        <div id="footer-top">
            <!-- COMPANY INFO -->
            <div class="company-info">
                <figure class="logo small">
                    <img src="{{URL::to('images/logo1.png')}}" alt="logo-small">
                </figure>
                <p>@lang('pages_text.footer_short_desc')</p>
                <!--<ul class="company-info-list">
                    <li class="company-info-item">
                        <span class="icon-present"></span>
                        <p><span></span></p>
                    </li>
                    <li class="company-info-item">
                        <span class="icon-user"></span>
                        <p><span></span></p>
                    </li>
                    <li class="company-info-item">
                        <span class="icon-user"></span>
                        <p><span></span></p>
                    </li>
                </ul> -->
                <!-- SOCIAL LINKS -->
                <ul class="social-links">
                    <li class="social-link fb">
                        <a href="#"></a>
                    </li>
                    <li class="social-link twt">
                        <a href="#"></a>
                    </li>
                </ul>
                <!-- /SOCIAL LINKS -->
            </div>
            <!-- /COMPANY INFO -->

            <!-- LINK INFO -->
            <div class="link-info">
                <p class="footer-title"> @lang('footer.our_community')</p>
                <!-- LINK LIST -->
                <ul class="link-list">
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.joinus')}}">@lang('footer.how_join_us')</a>
                    </li>

                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.jobs')}}">@lang('footer.jobs')</a>
                    </li>
                </ul>
                <!-- /LINK LIST -->
            </div>
            <!-- /LINK INFO -->

            <!-- LINK INFO -->
            <div class="link-info">
                <p class="footer-title">@lang('footer.member_links')</p>
                <!-- LINK LIST -->
                <ul class="link-list">
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('user.wallet')}}">@lang('footer.your_wallet')</a>
                    </li>
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.products')}}">@lang('footer.browse_latest')</a>
                    </li>

                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('user.royality')}}">@lang('footer.invite_friend')</a>
                    </li>
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.app')}}">@lang('menu.mobile_app')</a>
                    </li>
                </ul>
                <!-- /LINK LIST -->
            </div>
            <!-- /LINK INFO -->

            <!-- LINK INFO -->
            <div class="link-info">
                <p class="footer-title">@lang('footer.help_faq')</p>
                <!-- LINK LIST -->
                <ul class="link-list">
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.privacy')}}">@lang('footer.help_center')</a>
                    </li>
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.faq')}}">@lang('footer.faqs')</a>
                    </li>
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.terms')}}">@lang('footer.terms')</a>
                    </li>
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.cookies')}}">@lang('footer.cookie')</a>
                    </li>
                    <li class="link-item">
                        <div class="bullet"></div>
                        <a href="{{route('marketplace.legal.reject')}}">@lang('footer.reject')</a>
                    </li>
                    @if(Auth::guard('store')->check())
                        <li class="link-item">
                            <div class="bullet"></div>
                            <a href="{{route('marketplace.legal.seller_contract')}}">@lang('footer.seller_contract')</a>
                        </li>
                    @endif
                </ul>
                <!-- /LINK LIST -->
            </div>
            <!-- /LINK INFO -->

            <!-- LINK INFO -->
            <div class="link-info">
                <p class="footer-title">@lang('footer.lang')</p>
                <!-- LINK LIST -->
                <ul class="link-list">
                    <div>
                        <a href="{{ route('marketplace.set_locale',['locale' => 'it']) }}"><img src="{{URL::to('images/dashboard/flag-ita.png')}}"></a>
                        <a href="{{ route('marketplace.set_locale',['locale' => 'en']) }}"><img src="{{URL::to('images/dashboard/flag-eng.png')}}"></a>
                    </div>
                </ul>
                <!-- /LINK LIST -->
            </div>
            <!-- /LINK INFO -->

        </div>
    </div>
    <!-- /FOOTER TOP -->

    <!-- FOOTER BOTTOM -->
    <div id="footer-bottom-wrap">
        <div id="footer-bottom">
            <p><span>&copy;</span> {{\Illuminate\Support\Carbon::now()->year}} - @lang('pages_text.footer_copyright') </p>
        </div>
    </div>
    <!-- /FOOTER BOTTOM -->
</footer>
<!-- /FOOTER -->