@extends('store.layouts.store_layout')

@section('page_title') @lang('page_titles.invoices_page') @endsection

@section('custom_css')
    <link rel="stylesheet" href="{{URL::to('css/vendor/bootstrap-datepicker3.standalone.min.css')}}">
@endsection

@section('page_content')

    <div class="dashboard-content">
        <!-- HEADLINE -->
        <div class="headline statement primary">
            <h4>@lang('store_panel.invoice_panel_title') ({{$totalInvoices}})</h4>
        </div>
        <!-- /HEADLINE -->

        <!-- TRANSACTION LIST -->
        <div class="transaction-list">

            <div class="transaction-list-header">
                <div class="transaction-list-header-date">
                    <p class="text-header small">@lang('store_panel.invoice_table_no')</p>
                </div>
                <div class="transaction-list-header-author">
                    <p class="text-header small">@lang('store_panel.invoice_table_date')</p>
                </div>
                <div class="transaction-list-header-item">
                    <p class="text-header small">@lang('store_panel.invoice_freeback_fee')</p>
                </div>
                <div class="transaction-list-header-detail">
                    <p class="text-header small">@lang('store_panel.invoice_cashback')</p>
                </div>
                <div class="transaction-list-header-code">
                    <p class="text-header small">@lang('store_panel.invoice_table_import')</p>
                </div>
                <div class="transaction-list-header-price">
                    <p class="text-header small">@lang('store_panel.invoice_table_status')</p>
                </div>
                <div class="transaction-list-header-cut">
                    <p class="text-header small">@lang('store_panel.invoice_table_download')</p>
                </div>
                <div class="transaction-list-header-icon"></div>
            </div>

            @foreach($invoices as $invoice)
                <div class="transaction-list-item">
                    <div class="transaction-list-item-date">
                        <p>WEB-{{$invoice->invoice_number}}-{{$invoice->created_at->format('y')}}</p>
                    </div>
                    <div class="transaction-list-item-author">
                        <p class="text-header">{{$invoice->created_at->format('d/m/20y')}}</p>
                    </div>
                    <div class="transaction-list-item-item">
                        <p>€{{number_format($invoice->freeback_fee,2)}}</p>
                    </div>
                    <div class="transaction-list-item-detail">
                        <p>€{{number_format($invoice->cashback_fee,2)}}</p>
                    </div>
                    <div class="transaction-list-item-code">
                        <p><span class="light">€{{number_format($invoice->total,2)}}</span></p>
                    </div>
                    <div class="transaction-list-item-price">
                        @if($invoice->paid)
                            <p>@lang('store_panel.invoice_payment_ok')</p>
                         @else
                            <p>@lang('store_panel.invoice_payment_missing')</p>
                         @endif
                    </div>
                    <div class="transaction-list-item-cut">
                        <p><span class="light"><a href="{{route('store.invoice.download',['invoice_id' => $invoice->id ])}}" class="primary">@lang('store_panel.invoice_download_button')</a></span></p>
                    </div>
                </div>
            @endforeach

        <!-- PAGER -->
            <div class="pager-wrap">
                {{$invoices->links()}}
            </div>
            <!-- /PAGER -->
        </div>
        <!-- /TRANSACTION LIST -->
    </div>
    <!-- DASHBOARD CONTENT -->
@endsection

@section('custom_js')
    <script src="{{URL::to('js/vendor/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::to('js/dashboard-statement.js')}}"></script>
@endsection