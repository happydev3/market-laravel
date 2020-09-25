@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_faqs') @endsection

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
                        <i class="icon-question_answer"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.faq_page_heading')</h5>
                        <h6 class="sub-heading">@lang('admin.faq_page_subheading')</h6>
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
                    <div class="card-header">@lang('admin.add_new_faq_panel')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.create_faq.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="qst">@lang('admin.question_label')</label>
                                <input class="form-control" id="qst" placeholder="@lang('admin.question_placeholder')" type="text" name="question" required>
                            </div>

                            <div class="form-group">
                                <label for="answer">@lang('admin.answer_label')</label>
                                <textarea class="form-control" id="group" placeholder="@lang('admin.answer_placeholder')" cols="5" name="answer" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="langSelect">@lang('admin.language_label')</label>
                                <select class="form-control" id="langSelect" name="lang" required>
                                    <option value="it">IT</option>
                                    <option value="en">EN</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.add_category_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.available_faqs')</div>
                    <div class="card-body">
                        <table id="faqsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.category_table_id')</th>
                                <th>@lang('admin.faq_table_question')</th>
                                <th>@lang('admin.faq_table_answer')</th>
                                <th>@lang('admin.category_table_lang')</th>
                                <th>@lang('admin.category_table_status')</th>
                                <th>@lang('admin.category_table_actions')</th>
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
    <script>
        $('#faqsTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_get_faqs')}}","dataSrc":""},
            "columns" : [
                {"data" : "id"},
                {"data" : "question"},
                {"data" : "answer"},
                {"data" : "lang"},
                {
                    "data" : "active",
                    "render" : function(data){
                        if(data == 1) {
                            return "<span class=\"badge badge-success\">@lang('admin.status_active')</span>";
                        } else {
                            return "<span class=\"badge badge-primary\">@lang('admin.status_deactive')</span>";
                        }
                    }
                },
                {
                    "data" : "id",
                    "render" : function (data,type,row) {
                        var btn = '<a href="faq/switch/' + data + '\" class="btn btn-warning"> @lang('admin.enable_disable') </a>';
                        var btn2 = '  <a href="faq/edit/' + data + '\" class="btn btn-success"> @lang('admin.edit_faq_heading')</a>';
                        return btn + btn2;
                    }
                }
            ]
        });
    </script>
@endsection