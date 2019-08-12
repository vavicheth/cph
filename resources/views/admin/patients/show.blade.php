@extends('layouts.app')
{{--<style>--}}

    {{--.select2-container {--}}
        {{--width: 100% !important;--}}
        {{--padding: 0;--}}
    {{--}--}}

{{--</style>--}}
@section('content')
    <h3 class="page-title">@lang('quickadmin.patients.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.patients.fields.name')</th>
                            <td field-key='name'>{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.gender')</th>
                            <td field-key='gender'>{{ $patient->gender  == 1 ? 'Male' : 'Female' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.age')</th>
                            <td field-key='age'>{{ $patient->age }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.oranization')</th>
                            <td field-key='oranization'>{{ $patient->oranization->name_kh ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.diagnostic')</th>
                            <td field-key='diagnostic'>{{ $patient->diagnostic }}</td>
                        </tr>
                        <tr>
                            <th>Province</th>
                            <td field-key='province'>{{ $patient->province->province_en ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.contact')</th>
                            <td field-key='contact'>{{ $patient->contact }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.patients.fields.description')</th>
                            <td field-key='description'>{{ $patient->description }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->



<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Invoices</a></li>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Add New Invoice</button>

</ul>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['method' => 'POST', 'route' => ['admin.invoices.store']]) !!}

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('date', trans('quickadmin.invoices.fields.date').'*', ['class' => 'control-label']) !!}
                                            {!! Form::text('date', old('date'), ['class' => 'form-control date', 'placeholder' => '', 'required' => '']) !!}
                                            <p class="help-block"></p>
                                            @if($errors->has('date'))
                                                <p class="help-block">
                                                    {{ $errors->first('date') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                            {!! Form::number('patient_id', $patient->id, ['class' => 'form-control','style'=>'display:none', 'placeholder' => '', 'required' => '']) !!}

                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('invstate_id', trans('quickadmin.invoices.fields.invstate-id').'*', ['class' => 'control-label']) !!}
                                            {!! Form::select('invstate_id', $invstates, old('invstate_id'), ['class' => 'form-control select2','style'=>'width: 100% !important;padding: 0','id'=>'selectinvstates', 'required' => '']) !!}
                                            <p class="help-block"></p>
                                            @if($errors->has('invstate_id'))
                                                <p class="help-block">
                                                    {{ $errors->first('invstate_id') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('department_id', 'Department'.'*', ['class' => 'control-label']) !!}
                                            {!! Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control select2','style'=>'width: 100% !important;padding: 0','id'=>'selectinvstates', 'required' => '']) !!}
                                            <p class="help-block"></p>
                                            @if($errors->has('department_id'))
                                                <p class="help-block">
                                                    {{ $errors->first('department_id') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('description', trans('quickadmin.invoices.fields.description').'', ['class' => 'control-label']) !!}
                                            {!! Form::text('description', old('description'), ['class' => 'form-control ', 'placeholder' => '']) !!}
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>



<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="invoices">
<table class="table table-bordered table-striped {{ count($invoices) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.invoices.fields.date')</th>
                        <th>Invoice State</th>
                        <th>@lang('quickadmin.invoices.fields.total')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($invoices) > 0)
            @foreach ($invoices as $invoice)
                <tr data-entry-id="{{ $invoice->id }}">
                    <td field-key='date'>{{ $invoice->date }}</td>
                                <td field-key='invstate_id'>{{ $invoice->invstate->state ?? '' }}</td>
                                <td field-key='total'>{{ $invoice->total }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('invoice_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.invoices.restore', $invoice->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('invoice_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.invoices.perma_del', $invoice->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    <?php

                                        $start=\Carbon\Carbon::parse($invoice->created_at);
                                        $end=\Carbon\Carbon::now();
                                        $hour = $end->diffInHours($start);
                                        $duration_right=true;
                                        if ($hour > 24){
                                            $duration_right=false;
                                        }
                                    ?>

                                    @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1 || (\Illuminate\Support\Facades\Auth::user()->id == $invoice->creator && $duration_right==True))
                                        @can('invoice_view')
                                        <a href="{{ route('admin.invoices.show',[$invoice->id]) }}" class="btn btn-xs btn-primary">Add Medicine</a>
                                        @endcan
                                        @can('invoice_edit')
                                        <a href="{{ route('admin.invoices.edit',[$invoice->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('invoice_delete')
    {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                            'route' => ['admin.invoices.destroy', $invoice->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                    @endif
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.patients.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
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

        // $(document).ready(function(){
        //     $('#selectinvstates').on('change', function (e) {
        //         console.log(this.value);
        //     });
        // });



    </script>

@stop


