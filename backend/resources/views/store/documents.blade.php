@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.store_documents')  @endsection


@section('page_content')

    <!-- DASHBOARD CONTENT -->
    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline simple primary">
            <h4>@lang('store_panel.document_panel_title')</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-3-1 left">
            <form method="POST" action="{{ route('store.documents.submit') }}" enctype="multipart/form-data">
                <div class="form-box-item full">
                {{csrf_field()}}

                <!-- INPUT CONTAINER -->
                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.chamber_commerce')</label>
                        @if( $chamberDocument != null)
                            @if($chamberDocument->valid)
                                <p>@lang('store_panel.document_accepted')</p>
                            @else
                                <p>@lang('store_panel.document_validating')</p>
                            @endif
                        @else
                            <input type="file"  name="chamber_document">
                        @endif
                    </div>


                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.id_document')</label>
                        @if( $idDocument != null)
                            @if($idDocument->valid)
                                <p>@lang('store_panel.document_accepted')</p>
                            @else
                                <p>@lang('store_panel.document_validating')</p>
                            @endif
                        @else
                            <input type="file"  name="owner_id_doc">
                        @endif
                    </div>

                    <div class="input-container">
                        <label for="item_name" class="rl-label required">@lang('store_panel.vat_document')</label>
                        @if( $piva != null)
                            @if($piva->valid)
                                <p>@lang('store_panel.document_accepted')</p>
                            @else
                                <p>@lang('store_panel.document_validating')</p>
                            @endif
                        @else
                            <input type="file"  name="vat_document">
                        @endif
                    </div>

                    <!-- /INPUT CONTAINER -->

                    <div class="clearfix"></div>

                    <hr class="line-separator">
                    <button class="button big dark" type="submit">@lang('store_panel.upload_documents_btn')</button>
                </div>
            </form>

            <!-- /FORM BOX ITEM -->
        </div>
        <!-- /FORM BOX ITEMS -->

        <!-- FORM BOX ITEMS -->
        <div class="form-box-items wrap-1-3 right">
            <!-- FORM BOX ITEM -->
            <div class="form-box-item full">
                <h4>@lang('store_panel.document_guidelines')</h4>
                <hr class="line-separator">
                <!-- PLAIN TEXT BOX -->
                <div class="plain-text-box">

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.documents_guideline1')</p>
                        <p>@lang('store_panel.documents_guideline1_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.documents_guideline2')</p>
                        <p>@lang('store_panel.documents_guideline2_desc')</p>
                    </div>
                    <!-- /PLAIN TEXT BOX ITEM -->

                    <!-- PLAIN TEXT BOX ITEM -->
                    <div class="plain-text-box-item">
                        <p class="text-header">@lang('store_panel.documents_guideline3')</p>
                        <p>@lang('store_panel.documents_guideline3_desc')</p>
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