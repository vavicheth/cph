@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.departments.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.departments.fields.name')</th>
                            <td field-key='name'>{{ $department->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.departments.fields.name-kh')</th>
                            <td field-key='name_kh'>{{ $department->name_kh }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.departments.fields.abr')</th>
                            <td field-key='abr'>{{ $department->abr }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.departments.fields.abr-kh')</th>
                            <td field-key='abr_kh'>{{ $department->abr_kh }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.departments.fields.beds')</th>
                            <td field-key='beds'>{{ $department->beds }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.departments.fields.description')</th>
                            <td field-key='description'>{{ $department->description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.departments.fields.active')</th>
                            <td field-key='active'>{{ Form::checkbox("active", 1, $department->active == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#rooms" aria-controls="rooms" role="tab" data-toggle="tab">Rooms</a></li>
<li role="presentation" class=""><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="rooms">
<table class="table table-bordered table-striped {{ count($rooms) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.rooms.fields.department')</th>
                        <th>@lang('quickadmin.rooms.fields.category')</th>
                        <th>@lang('quickadmin.rooms.fields.room')</th>
                        <th>@lang('quickadmin.rooms.fields.bed')</th>
                        <th>@lang('quickadmin.rooms.fields.description')</th>
                        <th>@lang('quickadmin.rooms.fields.active')</th>
                        <th>@lang('quickadmin.rooms.fields.created-by')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($rooms) > 0)
            @foreach ($rooms as $room)
                <tr data-entry-id="{{ $room->id }}">
                    <td field-key='department'>{{ $room->department->name ?? '' }}</td>
                                <td field-key='category'>{{ $room->category->type ?? '' }}</td>
                                <td field-key='room'>{{ $room->room }}</td>
                                <td field-key='bed'>{{ $room->bed }}</td>
                                <td field-key='description'>{{ $room->description }}</td>
                                <td field-key='active'>{{ Form::checkbox("active", 1, $room->active == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='created_by'>{{ $room->created_by->name ?? '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('room_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.rooms.restore', $room->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('room_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.rooms.perma_del', $room->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('room_view')
                                    <a href="{{ route('admin.rooms.show',[$room->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('room_edit')
                                    <a href="{{ route('admin.rooms.edit',[$room->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('room_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.rooms.destroy', $room->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="users">
<table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.users.fields.name')</th>
                        <th>@lang('quickadmin.users.fields.email')</th>
                        <th>@lang('quickadmin.users.fields.role')</th>
                        <th>@lang('quickadmin.users.fields.department')</th>
                                                <th>&nbsp;</th>

        </tr>
    </thead>

    <tbody>
        @if (count($users) > 0)
            @foreach ($users as $user)
                <tr data-entry-id="{{ $user->id }}">
                    <td field-key='name'>{{ $user->name }}</td>
                                <td field-key='email'>{{ $user->email }}</td>
                                <td field-key='role'>{{ $user->role->title ?? '' }}</td>
                                <td field-key='department'>{{ $user->department->name ?? '' }}</td>
                                                                <td>
                                    @can('user_view')
                                    <a href="{{ route('admin.users.show',[$user->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('user_edit')
                                    <a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('user_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.users.destroy', $user->id])) !!}
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

            <a href="{{ route('admin.departments.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


