@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.departments.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.departments.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.departments.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Department name', 'required' => '']) !!}
                    <p class="help-block">Department name</p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name_kh', trans('quickadmin.departments.fields.name-kh').'', ['class' => 'control-label']) !!}
                    {!! Form::text('name_kh', old('name_kh'), ['class' => 'form-control', 'placeholder' => 'Department name in khmer']) !!}
                    <p class="help-block">Department name in khmer</p>
                    @if($errors->has('name_kh'))
                        <p class="help-block">
                            {{ $errors->first('name_kh') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('abr', trans('quickadmin.departments.fields.abr').'', ['class' => 'control-label']) !!}
                    {!! Form::text('abr', old('abr'), ['class' => 'form-control', 'placeholder' => 'Abbreviation Department Name']) !!}
                    <p class="help-block">Abbreviation Department Name</p>
                    @if($errors->has('abr'))
                        <p class="help-block">
                            {{ $errors->first('abr') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('abr_kh', trans('quickadmin.departments.fields.abr-kh').'', ['class' => 'control-label']) !!}
                    {!! Form::text('abr_kh', old('abr_kh'), ['class' => 'form-control', 'placeholder' => 'Abbreviation Khmer of Department']) !!}
                    <p class="help-block">Abbreviation Khmer of Department</p>
                    @if($errors->has('abr_kh'))
                        <p class="help-block">
                            {{ $errors->first('abr_kh') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('beds', trans('quickadmin.departments.fields.beds').'', ['class' => 'control-label']) !!}
                    {!! Form::number('beds', old('beds'), ['class' => 'form-control', 'placeholder' => 'Total beds of department']) !!}
                    <p class="help-block">Total beds of department</p>
                    @if($errors->has('beds'))
                        <p class="help-block">
                            {{ $errors->first('beds') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.departments.fields.description').'', ['class' => 'control-label']) !!}
                    {!! Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('active', trans('quickadmin.departments.fields.active').'', ['class' => 'control-label']) !!}
                    {!! Form::hidden('active', 0) !!}
                    {!! Form::checkbox('active', 1, old('active', true), []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('active'))
                        <p class="help-block">
                            {{ $errors->first('active') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

