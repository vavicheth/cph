@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.invoicedetails.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.invoicedetails.fields.medicine')</th>
                            <td field-key='medicine'>{{ $invoicedetail->medicine->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoicedetails.fields.type')</th>
                            <td field-key='type'>{{ $invoicedetail->type }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoicedetails.fields.qty')</th>
                            <td field-key='qty'>{{ $invoicedetail->qty }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoicedetails.fields.unit-price')</th>
                            <td field-key='unit_price'>{{ $invoicedetail->unit_price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoicedetails.fields.total')</th>
                            <td field-key='total'>{{ $invoicedetail->total }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.invoicedetails.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


