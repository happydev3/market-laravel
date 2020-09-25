@extends('admin.layouts.admin_layout')

@section('page_title') @lang('admin.edit_tradedoubler_store') @endsection

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
                        <i class="icon-eye"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.edit_tradedoubler_panel_title')</h5>
                        <h6 class="sub-heading">@lang('admin.td_stores_subheader') </h6>
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
                    <div class="card-header">@lang('admin.edit_tradedoubler_panel_title')</div>
                    <div class="card-body">
                        <form action="{{ route('admin.edit_tradedoubler.submit') }}" method="POST" enctype="multipart/form-data" id="update-td-store">
                            {{ csrf_field() }}
                            <input type="hidden" name="store_id" value="{{$tdStore->id}}">
                            <div class="form-group">
                                <label for="storeName">@lang('admin.td_store_name')</label>
                                <input class="form-control" type="text" name="store_name" value="{{$tdStore->name}}" placeholder="@lang('admin.td_store_placeholder')" required id="storeName">
                            </div>

                            <div class="form-group">
                                <label for="email">E-Mail</label>
                                <input class="form-control" type="email" name="email" placeholder="E-Mail" value="{{$tdStore->email}}" required id="email">
                            </div>

                            <div class="form-group">
                                <label for="program_id">Program ID</label>
                                <input class="form-control" type="text" name="program_id" placeholder="Program ID" value="{{$tdStore->program_id}}" required id="program_id">
                            </div>


                            <div class="form-group">
                                <img src="{{URL::to($tdStore->front_thumbnail)}}"> <br/> <br/>
                                <label for="tdPhoto">@lang('admin.store_front_thumbnail')</label>
                                <input class="form-control tdphoto" id="tdPhoto1" placeholder="@lang('admin.store_front_thumbnail')" type="file" name="front_thumbnail" accept="image/*">
                            </div>

                            <div class="form-group">
                                <img src="{{URL::to($tdStore->logo)}}"> <br/> <br/>
                                <label for="tdPhoto">@lang('admin.store_logo_img')</label>
                                <input class="form-control tdphoto" id="tdPhoto2" placeholder="@lang('admin.store_logo_img')" type="file" name="logo" accept="image/*">
                            </div>

                            <div class="form-group">
                                <img src="{{URL::to($tdStore->bg_image)}}"> <br/> <br/>
                                <label for="tdPhoto">@lang('admin.store_background_img')</label>
                                <input class="form-control tdphoto" id="tdPhoto3" placeholder="@lang('admin.store_background_img')" type="file" name="background_img" accept="image/*">
                            </div>



                            <div class="form-group">
                                <label for="storeName">@lang('admin.tracking_time')</label>
                                <select class="form-control" name="tracking_time" required>
                                    <option value="day" @if($tdStore->tracking_time == "day") selected @endif>@lang('pages_text.time_day')</option>
                                    <option value="week" @if($tdStore->tracking_time == "week") selected @endif  >@lang('pages_text.time_week')</option>
                                    <option value="month" @if($tdStore->tracking_time == "month") selected @endif >@lang('pages_text.time_month')</option>
                                    <option value="3month" @if($tdStore->tracking_time == "3month") selected @endif >@lang('pages_text.time_3month')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="storeName">@lang('admin.credit_time')</label>
                                <select class="form-control" name="credit_time" required>
                                    <option value="day" @if($tdStore->credit_time == "day") selected @endif>@lang('pages_text.time_day')</option>
                                    <option value="week" @if($tdStore->credit_time == "week") selected @endif>@lang('pages_text.time_week')</option>
                                    <option value="month" @if($tdStore->credit_time == "month") selected @endif>@lang('pages_text.time_month')</option>
                                    <option value="3month" @if($tdStore->credit_time == "3month") selected @endif>@lang('pages_text.time_3month')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="storeName">@lang('admin.store_category')</label>
                                <select class="form-control" name="store_category" required>
                                    @foreach($storeCategories as $sc)
                                        <option value="{{$sc->id}}" @if($tdStore->store_category_id == $sc->id) selected @endif>{{$sc->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="targetUrl">@lang('admin.td_target_url')</label>
                                <input class="form-control" type="text" name="target_url" value="{{$tdStore->target_url}}" placeholder="@lang('admin.td_target_url_placeholder')" required id="targetUrl">
                            </div>

                            <div class="form-group">
                                <label for="cashback">@lang('admin.td_cashback')</label>
                                <input class="form-control" type="number" max="99" min="0" step="0.1" name="cashback" value="{{$tdStore->cashback}}" placeholder="@lang('admin.td_cashback_placeholder')" required id="cashback" value="0">
                            </div>

                            <div class="form-group">
                                <label for="tdPhoto">@lang('admin.store_description')</label>
                                <textarea class="form-control" rows="10" name="description">{{$tdStore->store_description}}</textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-success">@lang('admin.update_store')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.td_store_discounts') {{$tdStore->name}}</div>

                    <div class="card-body">
                        <table id="td-discounts-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.td_store_discounts_table_category')</th>
                                <th>@lang('admin.td_store_discounts_table_import')</th>
                                <th>@lang('admin.td_store_discounts_table_real_import')</th>
                                <th>@lang('admin.td_store_discounts_table_status')</th>
                                <th>@lang('admin.td_store_discounts_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <a href="{{route('admin.tradedoubler.create_discount',['id' => $tdStore->id])}}" class="btn btn-success">@lang('admin.td_store_discount_add_btn')</a>
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
        $('#td-discounts-table').DataTable({
            "ajax" : {"url" : " {{route('admin.ajax_tradedoubler_discounts',['id' => $tdStore->id])}}","dataSrc":""},
            "columns" : [
                {"data" : "category"},
                {
                    "data" : "cashback",
                    "render" : function(data){
                      return data + "%";
                    }
                },
                {
                  "data" : "cashback",
                  "render" : function(data){
                      return data - ((30/100) * data) + "%";
                  }
                },
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
                        var btn = '<a href="https://www.freeback.it/admin/tradedoubler/discount/switch/' + data + '\" class="btn btn-warning"> @lang('admin.enable_disable')</a>';
                        var btn2 = '<a href="https://www.freeback.it/admin/tradedoubler/discount/edit/' + data + '\" class="btn btn-success"> @lang('admin.td_store_discount_edit')</a>';
                        return btn + " " + btn2 ;
                    }
                }
            ]
        });
    </script>
    <script>
        $('.tdphoto').change(function(){
            $('#update-td-store').submit();
        });
    </script>
@endsection