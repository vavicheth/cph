@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.medicines.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.name')</th>
                            <td field-key='name'>{{ $medicine->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.type')</th>
                            <td field-key='type'>{{ $medicine->type }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.price')</th>
                            <td field-key='price'>{{ $medicine->price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.extend-price')</th>
                            <td field-key='extend_price'>{{ $medicine->extend_price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.expire-date')</th>
                            <td field-key='expire_date'>{{ $medicine->expire_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.company')</th>
                            <td field-key='company'>{{ $medicine->company }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.manual')</th>
                            <td field-key='manual'>{{ Form::checkbox("manual", 1, $medicine->manual == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.description')</th>
                            <td field-key='description'>{!! $medicine->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.medicines.fields.active')</th>
                            <td field-key='active'>{{ Form::checkbox("active", 1, $medicine->active == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#invoicedetails" aria-controls="invoicedetails" role="tab" data-toggle="tab">Invoice Details</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="invoicedetails">
<table class="table table-bordered table-striped {{ count($invoicedetails) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.invoicedetails.fields.medicine')</th>
                        <th>@lang('quickadmin.invoicedetails.fields.type')</th>
                        <th>@lang('quickadmin.invoicedetails.fields.qty')</th>
                        <th>@lang('quickadmin.invoicedetails.fields.unit-price')</th>
                        <th>@lang('quickadmin.invoicedetails.fields.total')</th>
                                                <th>&nbsp;</th>

        </tr>
    </thead>

    <tbody>
        @if (count($invoicedetails) > 0)
            @foreach ($invoicedetails as $invoicedetail)
                <tr data-entry-id="{{ $invoicedetail->id }}">
                    <td field-key='medicine'>{{ $invoicedetail->medicine->name ?? '' }}</td>
                                <td field-key='type'>{{ $invoicedetail->type }}</td>
                                <td field-key='qty'>{{ $invoicedetail->qty }}</td>
                                <td field-key='unit_price'>{{ $invoicedetail->unit_price }}</td>
                                <td field-key='total'>{{ $invoicedetail->total }}</td>
                                                                <td>
                                    @can('invoicedetail_view')
                                    <a href="{{ route('admin.invoicedetails.show',[$invoicedetail->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('invoicedetail_edit')
                                    <a href="{{ route('admin.invoicedetails.edit',[$invoicedetail->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('invoicedetail_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.invoicedetails.destroy', $invoicedetail->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.medicines.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.date').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });
            
        });
    </script>
            
@stop
