@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.organizations.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.name-kh')</th>
                            <td field-key='name_kh'>{{ $organization->name_kh }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.name-en')</th>
                            <td field-key='name_en'>{{ $organization->name_en }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.address')</th>
                            <td field-key='address'>{{ $organization->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.contact')</th>
                            <td field-key='contact'>{{ $organization->contact }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.description')</th>
                            <td field-key='description'>{!! $organization->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.organizations.fields.active')</th>
                            <td field-key='active'>{{ Form::checkbox("active", 1, $organization->active == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#patients" aria-controls="patients" role="tab" data-toggle="tab">Patients</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="patients">
<table class="table table-bordered table-striped {{ count($patients) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.patients.fields.name')</th>
                        <th>@lang('quickadmin.patients.fields.gender')</th>
                        <th>@lang('quickadmin.patients.fields.age')</th>
                        <th>@lang('quickadmin.patients.fields.oranization')</th>
                        <th>@lang('quickadmin.patients.fields.diagnostic')</th>
                        <th>@lang('quickadmin.patients.fields.address')</th>
                        <th>@lang('quickadmin.patients.fields.contact')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($patients) > 0)
            @foreach ($patients as $patient)
                <tr data-entry-id="{{ $patient->id }}">
                    <td field-key='name'>{{ $patient->name }}</td>
                                <td field-key='gender'>{{ $patient->gender }}</td>
                                <td field-key='age'>{{ $patient->age }}</td>
                                <td field-key='oranization'>{{ $patient->oranization->name_kh ?? '' }}</td>
                                <td field-key='diagnostic'>{{ $patient->diagnostic }}</td>
                                <td field-key='address'>{{ $patient->address }}</td>
                                <td field-key='contact'>{{ $patient->contact }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('patient_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.patients.restore', $patient->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('patient_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.patients.perma_del', $patient->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('patient_view')
                                    <a href="{{ route('admin.patients.show',[$patient->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('patient_edit')
                                    <a href="{{ route('admin.patients.edit',[$patient->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('patient_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.patients.destroy', $patient->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.organizations.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


