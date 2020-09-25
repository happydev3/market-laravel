@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_faq_edit') @endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-shop2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.edit_faq_heading')</h5>
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
                    <div class="card-header">@lang('admin.edit_faq_heading')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.faq_update.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="faqId" value="{{$faq->id}}">
                            <div class="form-group">
                                <label for="question">@lang('admin.question_label')</label>
                                <input class="form-control" id="question" placeholder="@lang('admin.question_placeholder')" type="text" name="question" value="{{ $faq->question }}">
                            </div>

                            <div class="form-group">
                                <label for="answer">@lang('admin.answer_label')</label>
                                <textarea class="form-control" id="group" placeholder="@lang('admin.answer_placeholder')" cols="5" name="answer" required>{{$faq->answer}}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="langSelect">@lang('admin.language_label')</label>
                                <select class="form-control" name="lang">
                                    <option value="it">IT</option>
                                    <option value="en">EN</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.update_faq_btn')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

