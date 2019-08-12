@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.invoicedetails.title')</h3>
    @can('invoicedetail_create')
    <p>
        <a href="{{ route('admin.invoicedetails.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($invoicedetails) > 0 ? 'datatable' : '' }} @can('invoicedetail_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('invoicedetail_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

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
                                @can('invoicedetail_delete')
                                    <td></td>
                                @endcan

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
@stop

@section('javascript') 
    <script>
        @can('invoicedetail_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.invoicedetails.mass_destroy') }}';
        @endcan

    </script>
@endsection