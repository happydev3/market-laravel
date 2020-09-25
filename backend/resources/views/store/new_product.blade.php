@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.add_new_product') @endsection
@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/fileinput.min.css')}}">
@endsection


@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_new_product.new_product')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_new_product.product_spec')</h4>
                <hr class="line-separator">
                <form id="upload_form" method="POST" action="{{route('store.add_product')}}" enctype="multipart/form-data">

                {{csrf_field()}}
                <!-- INPUT CONTAINER -->

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="input-container">
                        <label for="category"
                               class="rl-label required">@lang('store_new_product.select_category')</label>
                        <label for="category" class="select-block">
                            <select name="product_category" id="category" required>
                                @foreach($product_categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
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

                        @foreach ($errors as  $error)
                            <div>{{ $error }}</div>
                    @endforeach
                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_new_product.product_name')</label>
                        <input type="text" id="item_name" name="title" placeholder="@lang('store_new_product.new_product_placeholder')" required>
                    </div>
                    <!-- /INPUT CONTAINER -->

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="item_description"
                               class="rl-label required">@lang('store_new_product.product_desc')</label>
                        <textarea id="item_description" name="description"
                                  placeholder="@lang('store_new_product.product_desc_placeholder')" required></textarea>
                    </div>
                    <!-- /INPUT CONTAINER -->


                    <div class="input-container">
                        <label for="item_name"
                               class="rl-label required">@lang('store_new_product.product_quantity')</label>
                        <input type="text" id="item_name" name="qta"
                               placeholder="@lang('store_new_product.product_quantity_placeholder')" required>
                    </div>


                    <div class="input-container">
                        <label for="item_name"
                               class="rl-label required">@lang('store_new_product.product_price')</label>
                        <input type="text" id="item_price" name="price" placeholder="@lang('store_new_product.product_price_placeholder')" required>
                    </div>


                    <div class="input-container">
                        <label for="category"
                               class="rl-label required">@lang('store_new_product.product_currency')</label>
                        <label for="category" class="select-block">
                            <select name="currency" id="currency" required>
                                <option value="€">€</option>
                                <option value="$">$</option>
                                <option value="£">£</option>
                            </select>
                            <!-- SVG ARROW -->
                            <svg class="svg-arrow">
                                <use xlink:href="#svg-arrow"></use>
                            </svg>
                            <!-- /SVG ARROW -->
                        </label>
                    </div>

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label class="rl-label required">@lang('store_new_product.product_front_image')</label>
                        <!-- UPLOAD FILE -->
                        <div class="upload-file">
                            <input id="input-b3" name="front_img" type="file" class="file" data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
                        </div>
                        <!-- UPLOAD FILE -->
                    </div>

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label class="rl-label">@lang('store_new_product.additional_photos')</label>
                        <div class="upload-file">
                            <input id="input-b3" name="product_images[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
                        </div>

                    </div>
                    <!-- /INPUT CONTAINER -->


                    <div class="clearfix"></div>
                    <hr class="line-separator">
                    <input type="submit" class="button big dark" value="@lang('store_new_product.button_save_product')">
                </form>
            </div>
            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.upload_product_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.product_upload_title')</p>
                        <p>@lang('store_panel.product_upload_content')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.photos_title')</p>
                        <p>@lang('store_panel.photos_description')</p>

                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.help_title')</p>
                        <p><a href="#" class="primary">@lang('store_panel.help_request')</a></p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->
                </div>
                <!-- /PLAIN TEXT BOX -->
            </div>
            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->

        <div class="clearfix"></div>
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/fileinput/fileinput.min.js')}}"></script>
    <script src="{{URL::to('js/vendor/jquery.xmlinefill.min.js')}}"></script>
    <script src="{{URL::to('js/dashboard-uploaditem.js')}}"></script>
    <script>
        $('#input-b3').fileinput({
            theme : 'fa',
            language : "{{App::getLocale()}}",
            maxFileNum : 1,
            allowedFileTypes : ['image'],
        });
    </script>
@endsection