@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.store_informations') @endsection

@section('custom_css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline buttons primary">
            <h4>@lang('store_panel.store_settings_panel_title') {{Auth::guard('store')->user()->business_name}}</h4>
        </div>
        <!-- /HEADLINE -->

            <!-- FORM BOX ITEM -->
            <div class="form-box-item">
                <h4>@lang('store_panel.store_settings_sub_panel_title')</h4>

                @foreach ($errors->all() as $error)
                    <h6 style="color:red">{{ $error }}</h6>
                @endforeach
                <hr class="line-separator">
                <!-- PROFILE IMAGE UPLOAD -->
                <div class="profile-image">
                    <div class="profile-image-data">
                        <figure class="user-avatar medium">
                            <img src="{{URL::to(Auth::guard('store')->user()->getStoreLogo())}}" alt="profile-default-image">
                        </figure>
                        <p class="text-header">@lang('store_panel.store_icon')</p>
                        <p class="upload-details">@lang('store_panel.store_icon_size')</p>
                    </div>
                    <label for="store_profile_img" class="button mid-short dark-light">@lang('store_panel.store_icon_upload_btn')</label>
                </div>
                <!-- PROFILE IMAGE UPLOAD -->

                <form id="store-info-form" method="POST" action="{{route('store.info.update')}}" enctype="multipart/form-data">

                    {{csrf_field()}}
                    <input type="file" name="store_profile_img" id="store_profile_img" style="display:none" accept="image/png,image/gif,image/jpeg">

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="acc_name" class="rl-label required">@lang('store_panel.business_name')</label>
                        <input type="text" id="acc_name" name="business_name" value="{{Auth::guard('store')->user()->business_name}}" placeholder="@lang('store_panel.business_name_placeholder')" data-validation="required">
                    </div>
                    <!-- /INPUT CONTAINER -->


                    <div class="input-container">
                        <label for="new_pwd2" class="rl-label">@lang('store_panel.store_front_img_label')</label>
                            <img src="{{URL::to(Auth::guard('store')->user()->getStoreFrontImg())}}" width="258px" height="150px">
                        <label for="store_front_thumb" class="button mid-short dark-light">@lang('store_panel.store_front_image_update')</label>
                        <input type="file" name="store_thumb" style="display: none" id="store_front_thumb" >
                    </div>




                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="new_pwd2" class="rl-label">@lang('store_panel.bg_photo')</label>
                            <img src="{{URL::to(Auth::guard('store')->user()->getStoreBackgroundImg())}}" width="100%">
                        <label for="store_bg" class="button mid-short dark-light">@lang('store_panel.bg_photo_update_btn')</label>
                        <input type="file" name="store_bg" style="display: none" id="store_bg">
                    </div>

                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container half">
                        <label for="email" class="rl-label">@lang('auth.email_label')</label>
                        <input type="text" id="email" name="email" value="{{Auth::guard('store')->user()->email}}" placeholder="@lang('auth.email_input_placeholder')." data-validation="required email">
                        @if(!Auth::guard('store')->user()->email_verified) <p class="upload-details" style="color:orange">@lang('user_panel.email_not_verified')</p> @endif
                    </div>
                    <!-- /INPUT CONTAINER -->
                    <!-- INPUT CONTAINER -->
                    <div class="input-container half">
                        <label for="phone_no" class="rl-label">@lang('auth.phone_label')</label>
                        <input type="text" id="phone_no" name="phone_number" value="{{Auth::guard('store')->user()->phone_number}}" placeholder="@lang('auth.phone_number_placeholder')" data-validation="required">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="new_email" class="rl-label">@lang('store_panel.website')</label>
                        <input type="text" id="new_email" name="website" value="{{Auth::guard('store')->user()->website}}" placeholder="@lang('store_panel.website_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="ae_code" class="rl-label">@lang('store_panel.ae_label')</label>
                        <input type="text" id="ae_code" name="ae_code" value="{{Auth::guard('store')->user()->ae_code}}" placeholder="@lang('store_panel.ae_placeholder')">
                    </div>
                    <!-- /INPUT CONTAINER -->


                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="store_type" class="rl-label required">@lang('auth.store_cat_placeholder')</label>
                        <label for="store_type" class="select-block">
                            <select  name="store_category" id="store_category" required>
                                @foreach(\App\Models\StoreCategory::where('active',1)->orderBy('name','ASC')->get() as $c)
                                    <option value="{{$c->id}}" @if($c->id == Auth::guard('store')->user()->store_category_id) selected @endif> {{$c->name}}</option>
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
                        <label for="store_type" class="rl-label required">@lang('store_panel.store_type')</label>
                        <label for="store_type" class="select-block">
                            <select  name="store_type" id="store_type" required>
                                <option value="physical" @if(Auth::guard('store')->user()->store_type == "physical") selected @endif>@lang('auth.store_type_offline')</option>
                                <option value="online" @if(Auth::guard('store')->user()->store_type == "online") selected @endif>@lang('auth.store_type_online')</option>
                                <option value="both" @if(Auth::guard('store')->user()->store_type == "both") selected @endif>@lang('auth.store_type_both')</option>
                            </select>
                            <!-- SVG ARROW -->
                            <svg class="svg-arrow">
                                <use xlink:href="#svg-arrow"></use>
                            </svg>
                            <!-- /SVG ARROW -->
                        </label>
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <button type="submit" class="button medium secondary-dark">@lang('store_panel.update_info_btn')</button>
                </form>
            </div>
            <!-- /FORM BOX ITEM -->

    </div>
    <!-- DASHBOARD CONTENT -->

@endsection

@section('custom_js')

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>     <script>

        $('#store_profile_img').change(function(){
            $('#store-info-form').submit();
        });

        $('#store_front_thumb').change(function () {
            $('#store-info-form').submit();
        });

        $('#store_bg').change(function () {
            $('#store-info-form').submit();
        });

        $.validate({
            modules: 'file',
            lang: '{{App::getLocale()}}'
        });

    </script>

@endsection

