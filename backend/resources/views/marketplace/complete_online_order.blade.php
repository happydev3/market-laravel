@extends('marketplace.layouts.main_layout')

@section('page_title') @lang('page_titles.complete_payment_online') @endsection

@section('custom_css')
<style>
    #qrcode {
        width:42vh;
        height:42vh;
        padding: 4vh;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 8vh;
        background-color: white;
        margin-top:30px;
        border-radius: 2vh;
    }
</style>
@endsection

@section('page_content')

    <!-- SECTION HEADLINE -->
    <div class="section-headline-wrap">
        <div class="section-headline">
            <h2>@lang('pages_text.complete_payment')</h2>
            <p>Home<span class="separator">/</span><span class="current-section">@lang('pages_text.complete_payment')</span></p>
        </div>
    </div>
    <!-- /SECTION HEADLINE -->

    <div class="ht-banner-wrap">
        <!-- HT BANNER -->
        <div class="ht-banner">
            <!-- HT BANNER CONTENT -->
            <div class="ht-banner-content">
                <p class="text-header">@lang('pages_text.complete_payment_title')</p>
                <p>@lang('pages_text.complete_payment_desc')</p>
            </div>
            <!-- /HT BANNER CONTENT -->
        </div>
        <!-- /HT BANNER -->

        <!-- HT BANNER -->
        <div class="ht-banner void orange">
            <figure class="ht-banner-img3">
                <input type="hidden" disabled="" value="{{$pullId}}" id="pull_id">
                <div id="qrcode"></div>
            </figure>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/qrcode.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            var pullQR = new QRCode('qrcode');
            var pullId = $('#pull_id').val();
            pullQR.makeCode("https://dp.link/u/2/" +pullId);
        });

        setInterval(function(){
            $.ajax({
                url: "{{route('user.onlinetransaction.check',['pullId'=>$pullId])}}",
                success: function(data){
                   var status = data.status;
                   switch (status) {
                       case "completed":{
                           location.replace("{{route('order.completed')}}");
                           break;
                       }
                       case "created": {
                           break;
                       }
                       default:{
                           break;
                       }
                   }
                }
            });
        }, 1000);
    </script>
@endsection