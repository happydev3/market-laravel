@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.edit_product_images') @endsection
@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/fileinput.min.css')}}">
    <style>
        div.imgs{
            height:auto;
            width:auto;
            float:left;
            text-align:center;
        }
        div.imgs img {
            display: inline;
            padding: 5px;
        }
        div.desc {
            text-align: center;
            font-weight: normal;
            width: 183px;
            margin: 3px;
            padding: 5px;
        }
    </style>
@endsection


@section('page_content')


    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.edit_product_images_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.product_images_title')</h4>
                <hr class="line-separator">
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

                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                            <label class="rl-label required">@lang('store_new_product.product_front_image')</label>
                                <form action="{{ route('store.edit_thumb_img') }}" method="POST" enctype="multipart/form-data" id="front-img-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{ $product_id }}">
                                    <p align="center"><img src="{{URL::to($front_img->url)}}"></p>
                                    <br/>
                                    <label class="button small primary" for="front-img">@lang('store_panel.add_new_front_img')</label>
                                    <input type="file" name="front-img" style="visibility: hidden" id="front-img" accept="image/x-png,image/gif,image/jpeg">
                            </form>
                    </div>

                    <div class="input-container">
                        @foreach($multimedia as $image)
                            <div class="imgs">
                                <img src="{{ URL::to($image->url) }}" width="183" height="122">
                                <div class="descp"> <a href="{{ route('store.product.delete_img',['multimedia_id'=>$image->id ]) }}"> @lang('store_panel.delete_product_photo')</a> </div>
                            </div>
                        @endforeach
                    </div> <br/>



                    <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <form action="{{ route('store.upload_product_img') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label class="rl-label">@lang('store_new_product.additional_photos')</label>
                            <input type="hidden" name="product_id" value="{{$product_id}}">
                            <div class="upload-file">
                                <input id="input-b3" name="product_new_images[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="@lang('store_panel.img_upload_placeholder').">
                            </div>

                    </div>
                    <!-- /INPUT CONTAINER -->


                    <div class="clearfix"></div>
                    <hr class="line-separator">
                    <input type="submit" class="button big dark" value="@lang('store_new_product.button_update_images')">
                    </form>
            </div>
            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.product_multimedia_guideline')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.photos_title')</p>
                        <p>@lang('store_panel.photos_description')</p>

                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.help_title')</p>
                        <p><a href="{{route('store.help')}}" class="primary">@lang('store_panel.help_request')</a></p>
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


        $('#front-img').change(function () {
            $('#front-img-form').submit();
        })
    </script>
@endsection