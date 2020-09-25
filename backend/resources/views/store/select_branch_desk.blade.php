@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.select_branch_cashdesk') @endsection

@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.select_branch_desk_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form id="helpForm" method="POST" action="{{ route('store.branch.submit') }}">
                {{csrf_field()}}
                <div class="form-box-item full">
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.select_branch_title')</label>
                        <select name="branch_id" id="branch">
                            <option value="0" disabled selected></option>
                            @foreach($branches as $b)
                                @if($b->active == 1)
                                    <option value="{{$b->id}}"> {{$b->street_address}} </option>
                                @else
                                    <option value="{{$b->id}}"> {{$b->street_address}} (@lang('store_panel.disabled_branch'))</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.select_cashdesk')</label>
                        <select name="desk_id" id="desk">

                        </select>
                    </div>

                    <hr class="line-separator">
                    <button id="helpSend" class="button big dark">@lang('store_panel.select_branch_and_continue')</button>
                </div>
            </form>
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.branch_selection_guudelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">
                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.branch_selection_guideline1_title')</p>
                        <p>@lang('store_panel.branch_selection_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.branch_selection_guideline2_title')</p>
                        <p>@lang('store_panel.branch_selection_guideline2_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->
                </div>
                <!-- /PLAIN TEXT BOX -->
            </div>
        </div>
        <!-- /FORM BOX ITEMS -->
        <div class="clearfix"></div>
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection

@section('custom_js')
    <script>
        $('#branch').change(function(){
            $.getJSON( "{{URL::to('/')}}/store/branches/desks/" +$('#branch').val(), function( data ) {
                    var items = [];
                    $('#desk').empty();
                    $.each(data, function (key, val) {
                        if(val.active == 1){
                            $('#desk').append('<option value="' + val.id + '">' + val.desk_name + '</option>');
                        } else {
                            $('#desk').append('<option value="' + val.id + '">' + val.desk_name + " (@lang('store_panel.disabled_desk')) " + '</option>');
                        }
                    })
                }
            );
        });
    </script>
@endsection

