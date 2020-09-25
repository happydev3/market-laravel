@extends('admin.layouts.admin_layout')

@section('page_title') {{$store->business_name}}@lang('admin.admin_store_details') @endsection

@section('page_content')
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-shop2"></i>
                    </div>
                    <div class="page-title">
                        <h5>@lang('admin.details') {{ $store->business_name }}</h5>
                        <h6 class="sub-heading">@lang('admin.freeback_store')</h6>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="row gutters">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col">
                <a href="#" class="block-140">
                    <div class="icon primary">
                        <i class="icon-shopping-cart"></i>
                    </div>
                    <h5>{{$store->offline_transactions->count()}}</h5>
                    <p>@lang('admin.offline_transactions')</p>
                </a>
                <a href="#" class="block-140">
                    <div class="icon primary">
                        <i class="icon-gift2"></i>
                    </div>
                    <h5>{{$store->products->count()}}</h5>
                    <p>@lang('admin.products_available')</p>
                </a>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col">
                <a href="#" class="block-140">
                    <div class="icon primary">
                        <i class="icon-shopping-cart2"></i>
                    </div>
                    <h5>{{$store->online_transactions->count()}}</h5>
                    <p>@lang('admin.online_transactions')</p>
                </a>
                <a href="#" class="block-140">
                    <div class="icon primary">
                        <i class="icon-eye"></i>
                    </div>
                    <h5>{{$store->visits->count()}}</h5>
                    <p>@lang('admin.store_visitors')</p>
                </a>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col">
                <a href="#" class="block-140">
                    <div class="icon primary">
                        <i class="icon-arrow-down2"></i>
                    </div>
                    <h5>{{number_format($store->discount_rate,2)}} %</h5>
                    <p>@lang('admin.store_discount')</p>
                </a>
                <a href="#" class="block-140">
                    <div class="icon primary">
                        <i class="icon-chat2"></i>
                    </div>
                    <h5>{{$store->reviews->count()}}</h5>
                    <p>@lang('admin.store_reviews')</p>
                </a>
            </div>

            <div class="col-lg-12 col-xs-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('admin.store_activation')
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('admin.store.forcestatus')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="store_id" value="{{$store->id}}">
                            <div class="form-group">
                                @if($store->active)
                                    <label>@lang('admin.store_active')</label>
                                @else
                                    <label>@lang('admin.store_unactive')</label>
                                @endif
                            </div>

                            @if(\Illuminate\Support\Facades\Session::has('store_force_active'))
                                <p style="color:green">@lang('admin.store_activated_msg')</p>
                                {{\Illuminate\Support\Facades\Session::forget('store_force_active')}}
                            @endif

                            @if(\Illuminate\Support\Facades\Session::has('store_force_disable'))
                                <p style="color:red">@lang('admin.store_disabled_msg')</p>
                                {{\Illuminate\Support\Facades\Session::forget('store_force_disable')}}
                            @endif

                            <div class="form-group">
                                @if($store->active)
                                    <input type="submit" value="@lang('admin.store_disable')" class="btn btn-primary">
                                @else
                                    <input type="submit" value="@lang('admin.store_activate')" class="btn btn-success">
                                @endif

                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-lg-12 col-xs-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('admin.freeback_fee')
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('admin.store_update_fee')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="store_id" value="{{$store->id}}">
                            <div class="form-group">
                                <label for="feeRate">@lang('admin.freeback_fee')</label>
                                <input class="form-control" id="feeRate" placeholder="@lang('admin.freeback_fee_placeholder')" type="number" min="0" max="99.99" step="0.1" name="fb_fee" required="" value="{{number_format($store->freeback_rate,2)}}">
                            </div>

                            @if(\Illuminate\Support\Facades\Session::has('store_fee_updated'))
                                <p style="color:green">@lang('admin.store_fee_updated')</p>
                                {{\Illuminate\Support\Facades\Session::forget('store_fee_updated')}}
                            @endif
                            <div class="form-group">
                                <input type="submit" value="@lang('admin.update_fee_btn')" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.cash_transactions') ({{$store->cash_transactions->count()}})</div>
                    <div class="card-body">
                        <table id="cashTransactionsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_date')</th>
                                <th>@lang('admin.transaction_table_user')</th>
                                <th>@lang('admin.transaction_table_id')</th>
                                <th>@lang('admin.transaction_table_import')</th>
                                <th>@lang('admin.transaction_table_cashback')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.offline_transactions') ({{$store->offline_transactions->count()}})</div>
                    <div class="card-body">
                        <table id="offlineTransactionsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_date')</th>
                                <th>@lang('admin.transaction_table_user')</th>
                                <th>@lang('admin.transaction_table_id')</th>
                                <th>@lang('admin.transaction_table_import')</th>
                                <th>@lang('admin.transaction_table_cashback')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.online_transactions') ({{$store->online_transactions->count()}})</div>
                    <div class="card-body">
                        <table id="onlineTransactionsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('admin.transaction_table_date')</th>
                                    <th>@lang('admin.transaction_table_user')</th>
                                    <th>@lang('admin.transaction_table_id')</th>
                                    <th>@lang('admin.transaction_table_import')</th>
                                    <th>@lang('admin.transaction_table_cashback')</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.branches_panel_title')</div>
                    <div class="card-body">
                        <table id="branchesTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.branches_table_id')</th>
                                <th>@lang('admin.branches_table_address')</th>
                                <th>@lang('admin.branch_desks_count')</th>
                                <th>@lang('admin.branches_table_status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.store_products') ({{$store->products->count()}})</div>
                    <div class="card-body">
                        <table id="productsTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.product_image')</th>
                                <th>@lang('admin.product_title')</th>
                                <th>@lang('admin.product_price')</th>
                                <th>@lang('admin.product_quantity')</th>
                                <th>@lang('admin.product_status')</th>
                                <th>@lang('admin.users_table_actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.store_reviews')</div>
                    <div class="card-body">
                        <table id="reviewTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('admin.transaction_table_date')</th>
                                <th>@lang('admin.store_review_user')</th>
                                <th>@lang('admin.store_review_text')</th>
                                <th>@lang('admin.store_review_type')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">@lang('admin.documents_table')</div>
                    <div class="card-body">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>@lang('admin.document_table_date')</th>
                                <th>@lang('admin.document_table_type')</th>
                                <th>@lang('admin.document_table_view')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($store->documents as $d)
                                    <tr>
                                        <th scope="row">{{$d->created_at->format('d/m/20y')}}</th>
                                        <td>
                                            @if($d->type == "id")
                                                @lang('store_panel.id_document')
                                            @endif
                                            @if($d->type == "v_camerale")
                                                    @lang('store_panel.chamber_commerce')
                                            @endif
                                            @if($d->type == "piva")
                                                    @lang('store_panel.vat_document')
                                            @endif
                                        </td>
                                        <td><a href="https://www.freeback.it/{{$d->document_url}}" target="_blank" class="btn btn-success">@lang('admin.open_document')</a></td>
                                    </tr>
                                @endforeach
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFVt2WccdiOFmDTQhNaahcgp_v5yUhMRA&language=en&libraries=places"></script>
    <script src="{{URL::to('js/jquery.geocomplete.min.js')}}"></script>
    <script src="{{URL::to('js/gmaps.js')}}"></script>
    <script>

        $('#offlineTransactionsTable').DataTable({
            "iDisplayLength": 5,
            "aaSorting": [[0,'desc']],
            "ajax" : {"url" : " {{route('admin.ajax_store_offline_tr',['id' => $store->id])}}","dataSrc":""},
            "columns" : [
                {"data" : "created_at"},
                {"data" : "user.name"},
                {
                    "data" : "id",
                    "render" : function(data){
                        return "TR_"+data;
                    }
                },
                {
                    "data" : "full_import",
                    "render": function(data){
                        return data.toFixed(2) + "€";
                    }
                },
                {
                    "data" : "cashback_neto",
                    "render": function(data){
                        return data.toFixed(2) + "€";
                    }
                }
            ]
        });

        $('#cashTransactionsTable').DataTable({
            "iDisplayLength": 5,
            "aaSorting": [[0,'desc']],
            "ajax" : {"url" : " {{route('admin.ajax_store_cash_tr',['id' => $store->id])}}","dataSrc":""},
            "columns" : [
                {"data" : "created_at"},
                {"data" : "user.name"},
                {
                    "data" : "id",
                    "render" : function(data){
                        return "TR_"+data;
                    }
                },
                {
                    "data" : "full_import",
                    "render": function(data){
                        return data.toFixed(2) + "€";
                    }
                },
                {
                    "data" : "cashback_neto",
                    "render": function(data){
                        return data.toFixed(2) + "€";
                    }
                }
            ]
        });

        $('#branchesTable').DataTable({
            "iDisplayLength": 5,
            "aaSorting": [[0,'desc']],
            "ajax" : {"url" : " {{route('admin.ajax_store_branches',['id' => $store->id])}}","dataSrc":""},
            "columns" : [
                {"data" : "id"},
                {"data" : "street_address"},
                {"data" : "cash_desks_count"},
                {
                    "data" : "active",
                    "render" : function(data){
                        if(data == 1){
                            return "<span class=\"badge badge-success\">@lang('admin.status_active')</span>";
                        }
                        else {
                            return "<span class=\"badge badge-primary\">@lang('admin.status_deactive')</span>";
                        }
                    }
                },
            ]
        });


        $('#onlineTransactionsTable').DataTable({
            "iDisplayLength": 5,
            "aaSorting": [[0,'desc']],
            "ajax" : {"url" : " {{route('admin.ajax_store_online_tr',['id' => $store->id])}}","dataSrc":""},
            "columns" : [
                {"data" : "created_at"},
                {"data" : "user.name"},
                {
                    "data" : "id",
                    "render" : function(data){
                        return "TR_"+data;
                    }
                },
                {
                    "data" : "full_import",
                    "render": function(data){
                        return data + "€";
                    }
                },
                {
                    "data" : "cashback_neto",
                    "render": function(data){
                        return data + "€";
                    }
                }
            ]
        });

        $('#productsTable').DataTable({
            "iDisplayLength": 5,
            "ajax" : {"url" : "https://www.freeback.it/admin/ajax/store/products/" + "{{ $store->id }}","dataSrc":""},
            "columns" : [
                {
                    "data" : "multimedia[0].url",
                    "render": function(data){
                        return "<img height='100px' width='160px' src=\"https://www.freebackk.it/"+data+"\">";
                    }
                },
                {"data" : "title"},
                {
                    "data" : "price",
                    "render" : function(data){
                        return data + "€";
                    }
                },
                {"data" : "quantity_available"},
                {
                    "data" : "active",
                    "render":function(data){
                        if(data == 0)
                            return "<span class=\"badge badge-primary\">@lang('admin.status_unavailable')</span>";
                        else
                            return "<span class=\"badge badge-success\">@lang('admin.statis_available')</span>";
                    }
                },
                {
                    "data":"id",
                    "render":function(data){
                        //TODO Connect the Correct Product Route Here
                        return "<a href=\"#\" class=\"btn btn-success\" target=\"_blank\">" + "@lang('admin.visit_product')</a>";
                    }
                }
            ]
        });


        $('#reviewTable').DataTable({
            "iDisplayLength": 5,
            "aaSorting": [[0,'desc']],
            "ajax" : {"url" : " {{route('admin.ajax_store_reviews',['id' => $store->id])}}","dataSrc":""},
            "columns" : [
                {"data" : "created_at"},
                {"data" : "user.name"},
                {"data" : "review",},
                {"data" : "type"},
            ]
        });
    </script>
@endsection