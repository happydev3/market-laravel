@extends('user.layouts.dashboard_layout')

@section('page_title') @lang('page_titles.user_settings') @endsection

@section('page_content')

    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline buttons primary">
            @if(\Illuminate\Support\Facades\Session::has('no_address'))
                <h4>Inserisci l'Indirizzo di Spedizione prima di Procedere con l'acquisto</h4>
                {{\Illuminate\Support\Facades\Session::forget('no_address')}}
            @else
                <h4>@lang('user_panel.account_settings')  </h4>
            @endif
            @foreach ($errors->all() as $error)
                <h4>{{ $error }}</h4>
            @endforeach
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item">
                <h4>@lang('user_panel.profile_information')</h4>
                <hr class="line-separator">
                <!-- PROFILE IMAGE UPLOAD -->
                <div class="profile-image">
                    <div class="profile-image-data">
                        <figure class="user-avatar medium">
                            <img src="{{URL::to(Auth::user()->userAvatarLink())}}" alt="profile-default-image">
                        </figure>
                        <p class="text-header">@lang('user_panel.profile_photo')</p>
                        <p class="upload-details">@lang('user_panel.profile_photo_size')</p>
                    </div>
                    <label for="img_upload" class="button mid-short dark-light">@lang('user_panel.upload_img_btn')</label>
                </div>
                <!-- PROFILE IMAGE UPLOAD -->

                <form method="POST" action="{{route('user.update_profile.submit')}}" enctype="multipart/form-data" id="user-details-form">
                    {{csrf_field()}}
                    <input type="file" id="img_upload" name="profile_pic" style="display:none" accept="image/*">

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="acc_name" class="rl-label required">@lang('user_panel.name_surname')</label>
                        <input type="text" id="acc_name" name="name" value="{{Auth::user()->name}}" placeholder="@lang('user_panel.update_address_name_placeholder')" required>
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="new_email" class="rl-label">@lang('user_panel.email_address')</label>
                        <input type="email" id="new_email" name="email"  value="{{Auth::user()->email}}" placeholder="@lang('auth.email_input_placeholder')" required>

                        @if(\Illuminate\Support\Facades\Session::has('mail_occupied'))
                            <p class="upload-details" style="color:orange">@lang('user_panel.mail_occupied_msg')</p>
                            {{\Illuminate\Support\Facades\Session::forget('mail_occupied')}}
                        @else
                            @if(!Auth::user()->email_verified) <p class="upload-details" style="color:orange">@lang('user_panel.email_not_verified')</p> @endif
                        @endif


                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container ">
                        <label for="website_url" class="rl-label">@lang('user_panel.phone_no')</label>
                        <input type="text" id="website_url" name="phone_no" value="{{Auth::user()->phone_no}}" placeholder="@lang('auth.phone_number_placeholder')" required>

                        @if(\Illuminate\Support\Facades\Session::has('phone_no_occupied'))
                            <p class="upload-details" style="color:orange">@lang('user_panel.phone_occupied_msg')</p>
                            {{\Illuminate\Support\Facades\Session::forget('phone_no_occupied')}}
                        @else
                            @if(!Auth::user()->phone_verified) <p class="upload-details" style="color:orange">@lang('user_panel.phone_not_verified')</p> @endif
                        @endif

                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container half">
                        <label for="country1" class="rl-label">@lang('user_panel.country')</label>
                        <label for="country1" class="select-block">
                            <select name="country_id" id="country1">
                                <option value="0">@lang('user_panel.select_country_ph')</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" @if(Auth::user()->city->country_id == $country->id) selected @endif>{{$country->country_name}}</option>
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
                        <label for="country1" class="rl-label required">@lang('user_panel.city')</label>
                        <label for="country1" class="select-block">
                            <select name="city_id" id="country1">
                                <option value="0">@lang('user_panel.select_city_ph')</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @if(Auth::user()->city->id == $city->id) selected @endif>{{$city->city_name}}</option>
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
                    <div class="input-container">
                        <label class="rl-label">@lang('user_panel.preferences')</label>
                        <!-- CHECKBOX -->
                        <input type="checkbox" id="email_notif" name="newsletter" value="1" @if(Auth::user()->newsletter == 1) checked @endif>
                        <label for="email_notif" class="label-check">
                            <span class="checkbox primary"><span></span></span>
                            @lang('user_panel.newsletter_approval')
                        </label>
                        <!-- /CHECKBOX -->
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <button type="submit" class="button medium primary">@lang('user_panel.update_info_btn')</button>
                </form>
            </div>
            <!-- /FORM BOX ITEM -->

            <!-- FORM BOX ITEM -->
            <div class="form-box-item">
                <h4>@lang('user_panel.shipping_information')</h4>
                <hr class="line-separator">
                <form method="POST" action="{{route('user.cor_adress.submit')}}">
                    {{csrf_field()}}

                    <div class="input-container">
                        <label for="user-name" class="rl-label required">@lang('user_panel.update_address_name')</label>
                        <input type="text" id="user-name" name="name"  value="@if(Auth::user()->address != null) {{Auth::user()->address->name}}@endif" placeholder="@lang('user_panel.update_address_name_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="str_address" class="rl-label required">@lang('user_panel.full_address')</label>
                        <input type="text" id="str_address" name="street_address" value="@if(Auth::user()->address != null) {{Auth::user()->address->street_address}}  @endif"  placeholder="@lang('user_panel.full_address_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container half">
                        <label for="house-num" class="rl-label required">@lang('user_panel.house_number')</label>
                        <input type="text" id="house-num" name="street_number" value="@if(Auth::user()->address != null) {{Auth::user()->address->street_number}}  @endif" placeholder="@lang('user_panel.house_number_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container half">
                        <label for="zipcode" class="rl-label required">@lang('user_panel.zip_code')</label>
                        <input type="text" id="zipcode" name="zip" value="@if(Auth::user()->address != null) {{Auth::user()->address->postal_code}} @endif" placeholder="@lang('user_panel.zip_code_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                        <!-- INPUT CONTAINER -->
                        <div class="input-container half">
                            <label for="country1" class="rl-label">@lang('user_panel.country')</label>
                            <label for="country1" class="select-block">
                                <select name="country" id="country1">
                                    <option value="0">@lang('user_panel.select_country_ph')</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if(Auth::user()->city->country_id == $country->id) selected @endif>{{$country->country_name}}</option>
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
                            <input type="text"  id="city_in" value="@if(Auth::user()->address != null) {{Auth::user()->address->city}}  @endif" name="city" placeholder="@lang('user_panel.city_placeholder')">
                        </div>
                        <!-- /INPUT CONTAINER -->


                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="notes2" class="rl-label">@lang('user_panel.additional_notes')</label>
                        <textarea  id="notes2" name="notes" placeholder="@lang('user_panel.additional_notes_placeholder')">@if(Auth::user()->address != null) {{Auth::user()->address->additional_notes}}  @endif</textarea>
                    </div>
                    <!-- /INPUT CONTAINER -->
                    <button type="submit" class="button medium secondary">@lang('user_panel.update_shipping_infos_btn')</button>
                </form>
            </div>
            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX -->
    </div>

@endsection

@section('custom_js')

    <script>
        $('#img_upload').change(function(){
            $('#user-details-form').submit();
        })
    </script>


@endsection