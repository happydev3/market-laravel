@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.admin_manage_help_request') @endsection

@section('page_content')

    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-help"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.manage_request_header')</h5>
                        <h6 class="sub-heading">@lang('admin.manage_request_subheader') {{$request->id}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">@lang('admin.request_table_message')</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exOne">{{$request->store->business_name}}:</label>
                                    <p>{{$request->request}}</p>
                                </div>
                                <form action="{{route('admin.store_help_answer.submit')}}" method="POST">
                                    {{csrf_field()}}
                                    <input name="request_id" value="{{$request->id}}" hidden>
                                    <div class="form-group m-0">
                                        <label for="answerText">@lang('admin.answer_btn')</label>
                                        <textarea class="form-control" id="answerText" name="answer" rows="4" required></textarea>
                                    </div>

                                    <div class="form-group m-0">
                                        <br/>
                                        <button type="submit" class="btn btn-success">@lang('admin.answer_btn')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
    </div>
@endsection