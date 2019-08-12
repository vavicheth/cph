@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.medicines.title')</h3>
    @can('medicine_create')
    <p>
        <a href="{{ route('admin.medicines.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('medicine_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.medicines.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.medicines.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($medicines) > 0 ? 'datatable' : '' }} @can('medicine_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('medicine_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.medicines.fields.name')</th>
                        <th>@lang('quickadmin.medicines.fields.type')</th>
                        <th>@lang('quickadmin.medicines.fields.price')</th>
                        <th>@lang('quickadmin.medicines.fields.extend-price')</th>
                        <th>@lang('quickadmin.medicines.fields.expire-date')</th>
                        <th>@lang('quickadmin.medicines.fields.company')</th>
                        <th>@lang('quickadmin.medicines.fields.manual')</th>
                        <th>@lang('quickadmin.medicines.fields.description')</th>
                        <th>@lang('quickadmin.medicines.fields.active')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($medicines) > 0)
                        @foreach ($medicines as $medicine)
                            <tr data-entry-id="{{ $medicine->id }}">
                                @can('medicine_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='name'>{{ $medicine->name }}</td>
                                <td field-key='type'>{{ $medicine->type }}</td>
                                <td field-key='price'>{{ $medicine->price }}</td>
                                <td field-key='extend_price'>{{ $medicine->extend_price }}</td>
                                <td field-key='expire_date'>{{ $medicine->expire_date }}</td>
                                <td field-key='company'>{{ $medicine->company }}</td>
                                <td field-key='manual'>{{ Form::checkbox("manual", 1, $medicine->manual == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='description'>{!! $medicine->description !!}</td>
                                <td field-key='active'>{{ Form::checkbox("active", 1, $medicine->active == 1 ? true : false, ["disabled"]) }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('medicine_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.medicines.restore', $medicine->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('medicine_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.medicines.perma_del', $medicine->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('medicine_view')
                                    <a href="{{ route('admin.medicines.show',[$medicine->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('medicine_edit')
                                    <a href="{{ route('admin.medicines.edit',[$medicine->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('medicine_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.medicines.destroy', $medicine->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="14">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('medicine_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.medicines.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection