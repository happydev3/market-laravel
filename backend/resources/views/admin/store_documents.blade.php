@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_store_documents') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('admin-res/vendor/datatables/dataTables.bs4.css')}}" />
    <link rel="stylesheet" href="{{URL::to('admin-res/vendor/datatables/dataTables.bs4-custom.css')}}" />
@endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-layers"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.store_documents_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.store_documents_subheading')</h6>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="right-actions">
                        <span class="last-login">@lang('admin.stores_update') {{\Illuminate\Support\Carbon::now()->format('d/m/y-h:i')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.document_table_title')</div>
                    <div class="card-body">
                        <table id="documentsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.document_table_date')</th>
                                <th>@lang('admin.document_table_store')</th>
                                <th>@lang('admin.document_table_type')</th>
                                <th>@lang('admin.document_table_status')</th>
                                <th>@lang('admin.document_table_view')</th>
                                <th>@lang('admin.document_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.min.js')}}"></script>
    <script src="{{URL::to('admin-res/vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

    <script>
        $('#documentsTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_store_documents')}}","dataSrc":""},
            "aaSorting": [[0,'desc']],
            "columns" : [
                {"data" : "created_at"},
                {"data" : "store.business_name"},
                {
                    "data" : "type",
                    "render" : function(data){
                        if(data == "piva"){
                            return "@lang('store_panel.vat_document')";
                        }

                        if(data == "id"){
                            return "@lang('store_panel.id_document')";
                        }

                        if(data == "v_camerale"){
                            return "@lang('store_panel.chamber_commerce')";
                        }
                    }
                },
                {
                    "data" : "valid",
                    "render" : function(data){
                        if (data == 0)
                            return "<span class=\"badge badge-primary\">@lang('admin.document_uncheked_label')</span>";
                        else
                            return "<span class=\"badge badge-success\">@lang('admin.document_valid_label')</span>";
                    }
                },
                {
                    "data" : "document_url",
                    "render" : function (data) {
                        //TODO Right Link here
                        return "<a href=\"https://www.freeback.it/" + data +"\" class=\"btn btn-success btn-sm\" target=\"_blank\">" + "@lang('admin.open_document')</a>";
                    }
                },
                {
                    "data" : "id",
                    "render" :  function (data) {
                        var btn1 =  "<a href=\"store_document/accept/"+data+"\" class=\"btn btn-success btn-sm\">" + "@lang('admin.document_valid')</a>   ";
                        var btn2 =  "  <a href=\"store_document/decline/"+data+"\" class=\"btn btn-primary btn-sm\">" + "@lang('admin.document_invalid')</a>";

                        return btn1 + btn2;
                    }
                }
            ]
        });
    </script>
@endsection