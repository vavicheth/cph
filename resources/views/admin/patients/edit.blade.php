@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.patients.title')</h3>
    
    {!! Form::model($patient, ['method' => 'PUT', 'route' => ['admin.patients.update', $patient->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.patients.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('gender', trans('quickadmin.patients.fields.gender').'*', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('gender'))
                        <p class="help-block">
                            {{ $errors->first('gender') }}
                        </p>
                    @endif
                    <div>
                        <label>
                            {!! Form::radio('gender', '1', false, ['required' => '']) !!}
                            Male
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('gender', '2', false, ['required' => '']) !!}
                            Female
                        </label>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('age', trans('quickadmin.patients.fields.age').'', ['class' => 'control-label']) !!}
                    {!! Form::number('age', old('age'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('age'))
                        <p class="help-block">
                            {{ $errors->first('age') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('oranization_id', trans('quickadmin.patients.fields.oranization').'', ['class' => 'control-label']) !!}
                    {!! Form::select('oranization_id', $oranizations, old('oranization_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('oranization_id'))
                        <p class="help-block">
                            {{ $errors->first('oranization_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('diagnostic', trans('quickadmin.patients.fields.diagnostic').'', ['class' => 'control-label']) !!}
                    {!! Form::text('diagnostic', old('diagnostic'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('diagnostic'))
                        <p class="help-block">
                            {{ $errors->first('diagnostic') }}
                        </p>
                    @endif
                </div>
            </div>
            {{--<div class="row">--}}
                {{--<div class="col-xs-12 form-group">--}}
                    {{--{!! Form::label('address', trans('quickadmin.patients.fields.address').'', ['class' => 'control-label']) !!}--}}
                    {{--{!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => '']) !!}--}}
                    {{--<p class="help-block"></p>--}}
                    {{--@if($errors->has('address'))--}}
                        {{--<p class="help-block">--}}
                            {{--{{ $errors->first('address') }}--}}
                        {{--</p>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('province_id', 'Province'.'', ['class' => 'control-label']) !!}
                    {!! Form::select('province_id', $provinces, old('province_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('province_id'))
                        <p class="help-block">
                            {{ $errors->first('province_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('contact', trans('quickadmin.patients.fields.contact').'', ['class' => 'control-label']) !!}
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
                    {!! Form::label('description', trans('quickadmin.patients.fields.description').'', ['class' => 'control-label']) !!}
                    {!! Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent

    <script type="text/html" id="invoices-template">
        @include('admin.patients.invoices_row',
                [
                    'index' => '_INDEX_',
                ])
               </script > 

            <script>
        $('.add-new').click(function () {
            var tableBody = $(this).parent().find('tbody');
            var template = $('#' + tableBody.attr('id') + '-template').html();
            var lastIndex = parseInt(tableBody.find('tr').last().data('index'));
            if (isNaN(lastIndex)) {
                lastIndex = 0;
            }
            tableBody.append(template.replace(/_INDEX_/g, lastIndex + 1));
            return false;
        });
        $(document).on('click', '.remove', function () {
            var row = $(this).parentsUntil('tr').parent();
            row.remove();
            return false;
        });
        </script>
@stop