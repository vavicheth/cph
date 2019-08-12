@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.invoicedetails.title')</h3>
    
    {!! Form::model($invoicedetail, ['method' => 'PUT', 'route' => ['admin.invoicedetails.update', $invoicedetail->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('medicine_id', trans('quickadmin.invoicedetails.fields.medicine').'', ['class' => 'control-label']) !!}
                    {!! Form::select('medicine_id', $medicines, old('medicine_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('medicine_id'))
                        <p class="help-block">
                            {{ $errors->first('medicine_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('qty', trans('quickadmin.invoicedetails.fields.qty').'*', ['class' => 'control-label']) !!}
                    {!! Form::number('qty', old('qty'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('qty'))
                        <p class="help-block">
                            {{ $errors->first('qty') }}
                        </p>
                    @endif
                </div>
            </div>

            {!! Form::number('invoice_id', $invoicedetail->invoice->id, ['class' => 'form-control','style'=>'display:none', 'placeholder' => '', 'required' => '']) !!}
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

