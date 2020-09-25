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
                        <i class="icon-user-check"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.getter_table_title')</h5>
                        <h6 class="sub-heading">@lang('admin.getter_subtitle')</h6>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">@lang('admin.create_getter_title')</div>

                    <div class="card-body">
                        @foreach($errors->all() as $error)
                            <p style="color:red">{{$error}}</p>
                        @endforeach
                        <form action="{{route('admin.create_getter.submit')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">@lang('admin.getter_table_name')</label>
                                <input type="text" class="form-control" name="name" id="name" required placeholder="@lang('admin.getter_table_name')" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control @if($errors->has('email')) is-invalid @endif" required placeholder="Email" value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label for="iban">IBAN</label>
                                <input type="text" id="iban" name="iban" class="form-control @if($errors->has('iban')) is-invalid @endif" required placeholder="IBAN" value="{{old('iban')}}">
                            </div>

                            <div class="form-group">
                                <label for="fb_fee">@lang('admin.getter_percentage')</label>
                                <input type="number" step="0.1" min="1" max="99" id="fb_fee" name="fee_rate"  class="form-control @if($errors->has('fb_fee')) is-invalid @endif" required placeholder="@lang('admin.getter_percentage')" value="{{old('fb_dee')}}">
                            </div>

                            <div class="form-group">
                                <label for="getter-referral">@lang('admin.getter_table_referral')</label>
                                <input type="text" name="referral_code" placeholder="@lang('admin.getter_table_referral')" class="form-control @if(\Illuminate\Support\Facades\Session::has('getter_code_occupied')) is-invalid @endif">
                                {{\Illuminate\Support\Facades\Session::forget('getter_code_occupied')}}
                            </div>


                            <div class="form-group">
                                <label for="city">@lang('admin.getter_table_city')</label>
                                <select name="city_id" class="form-control" id="city" required>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" value="@lang('admin.getter_create_btn')" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.getter_table_title')</div>
                    <div class="card-body">
                        <table id="documentsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.getter_table_name')</th>
                                <th>@lang('admin.getter_table_mail')</th>
                                <th>@lang('admin.getter_table_referral')</th>
                                <th>@lang('admin.getter_table_city')</th>
                                <th>@lang('admin.getter_table_date')</th>
                                <th>@lang('admin.getter_table_status')</th>
                                <th>@lang('admin.getter_table_actions')</th>
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
            "ajax" : {"url" : " {{route('admin.get_getters')}}","dataSrc":""},
            "aaSorting": [[0,'desc']],
            "columns" : [
                {"data" : "name"},
                {"data" : "email"},
                {"data" : "referral_code"},
                {"data" : "city.city_name"},
                {
                    "data" : "created_at",
                    "render" : function(data){
                        return moment(data).format("DD/MM/YYYY - HH:MM") + 'h';
                    }
                },
                {
                    "data" : "active",
                    "render" : function(data){
                        if (data == 0)
                            return "<span class=\"badge badge-primary\">@lang('admin.status_deactive')</span>";
                        else
                            return "<span class=\"badge badge-success\">@lang('admin.status_active')</span>";
                    }
                },
                {
                    "data" : "id",
                    "render" : function (data) {
                        //TODO Right Link here
                        return "<a href=\" {{URL::to('/')}}/admin/getters/" + data +"\" class=\"btn btn-success btn-sm\"\">" + "@lang('admin.user_details_heading')</a>"
                               + " <a href=\"{{URL::to('/')}}/admin/getter/switch/" + data +"\" class=\"btn btn-primary btn-sm\"\">" + "@lang('admin.enable_disable')</a>";
                    }
                },
            ]
        });
    </script>
@endsection