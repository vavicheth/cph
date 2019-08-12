@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.organizations.title')</h3>
    
    {!! Form::model($organization, ['method' => 'PUT', 'route' => ['admin.organizations.update', $organization->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name_kh', trans('quickadmin.organizations.fields.name-kh').'', ['class' => 'control-label']) !!}
                    {!! Form::text('name_kh', old('name_kh'), ['class' => 'form-control', 'placeholder' => 'Organization\'s name in khmer']) !!}
                    <p class="help-block">Organization's name in khmer</p>
                    @if($errors->has('name_kh'))
                        <p class="help-block">
                            {{ $errors->first('name_kh') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name_en', trans('quickadmin.organizations.fields.name-en').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name_en', old('name_en'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name_en'))
                        <p class="help-block">
                            {{ $errors->first('name_en') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('address', trans('quickadmin.organizations.fields.address').'', ['class' => 'control-label']) !!}
                    {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('contact', trans('quickadmin.organizations.fields.contact').'', ['class' => 'control-label']) !!}
                    {!! Form::text('contact', old('contact'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('contact'))
                        <p class="help-block">
                            {{ $errors->first('contact') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.organizations.fields.description').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => '']) !!}
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
                    {!! Form::label('active', trans('quickadmin.organizations.fields.active').'', ['class' => 'control-label']) !!}
                    {!! Form::hidden('active', 0) !!}
                    {!! Form::checkbox('active', 1, old('active', old('active')), []) !!}
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

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

