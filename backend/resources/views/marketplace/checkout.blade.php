@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.checkout_page') @endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>Checkout</h2>
            <p>Home<span class="separator">/</span><span class="current-section">Checkout</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <!-- SECTION -->
    <div class="section-wrap">
        <div class="section">
            <!-- FORM BOX ITEMS -->
            <div class="form-box-items">
                <!-- FORM BOX ITEM -->
                <div class="form-box-item">
                    <h4>@lang('pages_text.shipping_details')</h4>
                    <hr class="line-separator">
                    <form id="checkout-form" method="POST" action="{{ route('user.cart.process') }}">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$product->id}}" name="product_id">
                        <div class="input-container">
                            <label for="user-name" class="rl-label required">@lang('user_panel.update_address_name')</label>
                            <input type="text" id="user-name" name="name"  value="@if($user->address != null) {{$user->address->name}}@endif" placeholder="@lang('user_panel.update_address_name_placeholder')" required>
                        </div>
                        <!-- INPUT CONTAINER -->
                        <div class="input-container">
                            <label for="str_address" class="rl-label required">@lang('user_panel.full_address')</label>
                            <input type="text" id="str_address" name="address" value="@if($user->address != null) {{$user->address->street_address}}  @endif"  placeholder="@lang('user_panel.full_address_placeholder')" required>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container half">
                            <label for="house-num" class="rl-label required">@lang('user_panel.house_number')</label>
                            <input type="text" id="house-num" name="house_number" value="@if($user->address != null) {{Auth::user()->address->street_number}}  @endif" placeholder="@lang('user_panel.house_number_placeholder')" required>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container half">
                            <label for="zipcode" class="rl-label required">@lang('user_panel.zip_code')</label>
                            <input type="text" id="zipcode" name="zip_code" value="@if($user->address != null) {{Auth::user()->address->postal_code}} @endif" placeholder="@lang('user_panel.zip_code_placeholder')" required>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container half">
                            <label for="country1" class="rl-label">@lang('user_panel.country')</label>
                            <label for="country1" class="select-block">
                                <select name="country" id="country1" required>
                                    <option value="0">@lang('user_panel.select_country_ph')</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if($user->city->country_id == $country->id) selected @endif>{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                                <!-- SVG ARROW -->
                                <svg class="svg-arrow">
                                    <use xlink:href="#svg-arrow"></use>
                                </svg>
                                <!-- /SVG ARROW -->
                            </label>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container half">
                            <label for="city_in" class="rl-label required">@lang('user_panel.city')</label>
                            <input type="text"  id="city_in" value="@if($user->address != null) {{Auth::user()->address->city}}  @endif" name="city" placeholder="@lang('user_panel.city_placeholder')" required>
                        </div>
                        <!-- /INPUT CONTAINER -->


                        <!-- INPUT CONTAINER -->
                        <div class="input-container">
                            <label for="notes2" class="rl-label">@lang('user_panel.additional_notes')</label>
                            <textarea  id="notes2" name="notes" placeholder="@lang('user_panel.additional_notes_placeholder')">@if($user->address != null) {{Auth::user()->address->additional_notes}}  @endif</textarea>
                        </div>
                        <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container" id="invoice_div" visible>
                            <label for="invoice_details" class="rl-label">@lang('user_panel.invoice_details')</label>
                            <textarea  id="invoice_details" name="invoice_details" placeholder="@lang('user_panel.invoice_details_placeholder')">@if($user->address != null) {{Auth::user()->address->additional_notes}}  @endif</textarea>
                        </div>
                        <!-- /INPUT CONTAINER -->
                        <!-- INPUT CONTAINER -->
                        <div class="input-container">
                            <!-- CHECKBOX -->
                            <input type="checkbox" id="same_add" name="same_add" value="same_address_invoice">
                            <label for="same_add" class="label-check b-label">
                                <span class="checkbox primary"><span></span></span>
                                @lang('pages_text.invoice_same_address')
                            </label>
                            <!-- /CHECKBOX -->
                        </div>
                        <!-- /INPUT CONTAINER -->
                    </form>
                </div>
                <!-- /FORM BOX ITEM -->

                <!-- FORM BOX ITEM -->
                <div class="form-box-item">
                    <h4>@lang('pages_text.payment_form')</h4>
                    <hr class="line-separator">
                    <p align="center">
                        <img src="{{URL::to($product->getWebThumb())}}">
                    </p>
                    <div class="input-container">
                        <label for="product_qta" class="rl-label">@lang('pages_text.quantity')</label>
                        <input type="number" form="checkout-form" id="product_qta" value="1" min="1" max="{{$product->quantity_available}}" name="product_quantity">
                    </div>
                    <p>@lang('pages_text.payment_terms_acceptance')</p>
                    <p>@lang('pages_text.payment_terms_desc')</p>
                    <hr class="line-separator top">
                    <button form="checkout-form" class="button big dark"> @lang('pages_text.confirm_order_btn') <span class="primary" id="price">({{ number_format($product->price,2) }} {{$product->currency}})</span></button>
                </div>
                <!-- /FORM BOX ITEM -->
            </div>
            <!-- /FORM BOX ITEMS -->
        </div>
    </div>
    <!-- /SECTION -->


@endsection

@section('custom_js') 

    <script>

        $('#same_add').click(function() {
            $("#invoice_div").toggle(!this.checked);
        });
        
        $('#product_qta').change(function () {
            val = $('#product_qta').val()
            var total = val * Number("{{$product->price}}")
            $('#price').text("(" + new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(total)+ ")")
        });
    </script>

@endsection