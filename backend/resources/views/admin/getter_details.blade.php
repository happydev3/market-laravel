@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.getter_details_page') @endsection

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
                        <h5>@lang('admin.getter_details_title') {{$getter->name}}</h5>
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
                    <div class="card-header">@lang('admin.getter_details')</div>
                    <div class="card-body">
                        @foreach($errors->all() as $error)
                            <p style="color:red">{{$error}}</p>
                        @endforeach

                        @if(\Illuminate\Support\Facades\Session::has('getter_updated'))
                            <p style="color:green">@lang('admin.update_success')</p>
                            {{\Illuminate\Support\Facades\Session::forget('getter_updated')}}
                        @endif

                        @if(\Illuminate\Support\Facades\Session::has('getter_mail_occupied'))
                            <p style="color:red">@lang('admin.mail_occupied')</p>
                            {{\Illuminate\Support\Facades\Session::forget('getter_mail_occupied')}}
                        @endif

                        @if(\Illuminate\Support\Facades\Session::has('getter_iban_occupied'))
                            <p style="color:red">@lang('admin.iban_occupied')</p>
                            {{\Illuminate\Support\Facades\Session::forget('getter_iban_occupied')}}
                        @endif

                        <form action="{{route('admin.getter.update')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="getter_id" value="{{$getter->id}}">
                            <div class="form-group">
                                <label for="name">@lang('admin.getter_table_name')</label>
                                <input type="text" class="form-control" name="name" id="name" required placeholder="@lang('admin.getter_table_name')" value="{{$getter->name}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control @if($errors->has('email')) is-invalid @endif" required placeholder="Email" value="{{$getter->email}}">
                            </div>
                            <div class="form-group">
                                <label for="iban">IBAN</label>
                                <input type="text" id="iban" name="iban" class="form-control @if($errors->has('iban')) is-invalid @endif" required placeholder="IBAN" value="{{$getter->iban}}">
                            </div>
                            <div class="form-group">
                                <label for="fb_fee">@lang('admin.getter_percentage')</label>
                                <input type="number" step="0.1" min="1" max="99" id="iban" name="fb_fee"  class="form-control @if($errors->has('fb_fee')) is-invalid @endif" required placeholder="@lang('admin.getter_percentage')" value="{{$getter->fee_rate}}">
                            </div>
                            <div class="form-group">
                                <label for="city">@lang('admin.getter_table_city')</label>
                                <select name="city_id" class="form-control" id="city" required>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if($getter->city_id == $city->id) selected @endif>{{$city->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" value="@lang('admin.getter_update_btn')" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">@lang('admin.getter_status')</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('admin.getter_table_referral')</label>
                            <input type="text" class="form-control" value="{{$getter->referral_code}}" disabled="">
                            <br>
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-3"> <div align="center" id="userReferralQR"> <h3>@lang('admin.qr_for_users')</h3></div> <br/> </div>
                                <div class="col-lg-3">  <div align="center" id="storeReferralQR"> <h3>@lang('admin.qr_for_stores')</h3></div><br/> </div>
                                <div class="col-lg-3"></div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>@lang('admin.getter_earnings')</label>
                            <input type="text" class="form-control" value="{{number_format($getter->fees_sum,2)}} €" disabled="">
                        </div>
                        <div class="form-group">
                            <label>@lang('admin.invited_users')</label>
                            <input type="text" class="form-control" value="{{$invitedUsers}}" disabled="">
                        </div>
                        <div class="form-group">
                            <label>@lang('admin.invited_stores')</label>
                            <input type="text" class="form-control" value="{{$invitedStores}}" disabled="">
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.transactions_table_title')</div>
                    <div class="card-body">
                        <table id="documentsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('admin.transaction_table_date')</th>
                                <th>@lang('admin.transaction_type')</th>
                                <th>@lang('admin.transaction_event')</th>
                                <th>@lang('admin.transaction_fb')</th>
                                <th>@lang('admin.getter_percentage')</th>
                                <th>@lang('admin.transaction_table_import')</th>
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
    <script src="{{URL::to('js/vendor/qrcode.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>


    <script>
        $('#documentsTable').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_getter.transactions',['id' => $getter->id])}}","dataSrc":""},
            "aaSorting": [[1,'desc']],
            "columns" : [
                {"data" : "id"},
                {
                    "data" : "created_at",
                    "render" : function(data){
                        return moment(data).format("DD/MM/YYYY - HH:MM") + 'h';
                    }
                },
                {"data" : "transaction_type"},
                {"data" : "event"},
                {
                    "data": "fb_fee_import",
                    "render": function(data){
                        return data + "€";
                    }
                },
                {
                    "data": "getter_fee_rate",
                    "render": function(data){
                        return data + "%";
                    }
                },
                {
                    "data": "import",
                    "render": function(data){
                        return data + "€";
                    }
                },
            ]
        });
        var qrCode = new QRCode('userReferralQR');
        qrCode.makeCode("{{route('user.refferal_register',['refferalCode' =>$getter->referral_code])}}");

        var qrCode2 = new QRCode('storeReferralQR');
        qrCode2.makeCode("{{route('store.refferal_register',['referralCode' =>$getter->referral_code])}}");
    </script>
@endsection