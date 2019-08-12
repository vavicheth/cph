@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.invoices.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Patient Name</th>
                            <td field-key='date'>{{ $invoice->patient->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoices.fields.date')</th>
                            <td field-key='date'>{{ $invoice->date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoices.fields.invstate-id')</th>
                            <td field-key='invstate_id'>{{ $invoice->invstate->state ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td field-key='invstate_id'>{{ $invoice->department->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoices.fields.total')</th>
                            <td field-key='total'>{{ $invoice->total }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.invoices.fields.description')</th>
                            <td field-key='description'>{!! $invoice->description !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->






            <div class="panel panel-info">
                <div class="panel-heading">
                    Create Invoice Detail
                </div>
                {!! Form::open(['method' => 'POST', 'route' => ['admin.invoicedetails.store']]) !!}
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

                    {!! Form::number('invoice_id', $invoice->id, ['class' => 'form-control','style'=>'display:none', 'placeholder' => '', 'required' => '']) !!}



                    @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1 || (\Illuminate\Support\Facades\Auth::user()->id == $invoice->creator && $duration_right==True))


                        {!! Form::submit('Add Medicine', ['class' => 'btn btn-info pull-right']) !!}

                    @endif

                    {!! Form::close() !!}
                </div>


            </div>



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
                            <th>@lang('quickadmin.invoicedetails.fields.unit-price') ($)</th>
                            <th>@lang('quickadmin.invoicedetails.fields.total') ($)</th>
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
                                            {{--<a href="{{ route('admin.invoicedetails.show',[$invoicedetail->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>--}}
                                        @endcan

                                        @if(\Illuminate\Support\Facades\Auth::user()->role->id == 1 || (\Illuminate\Support\Facades\Auth::user()->id == $invoice->creator && $duration_right==True))

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
                                        @endif
                                    </td>

                                </tr>
                        @endforeach

                        <tfoot>
                        <tr>
                            {{--<td></td>--}}
                            {{--<td></td>--}}
                            {{--<td></td>--}}
                            <td colspan="4" align="right"><b>Total ($):</b></td>
                            <td><b>{{number_format($invoice->invoicedetail->sum('total'),2)}}</b></td>
                            <td></td>

                        </tr>
                        </tfoot>


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

            <a href="{{ url('admin/patients/'. $invoice->patient_id) }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
            <a href="{{ url('admin/patients/create') }}" class="btn btn-primary">Add New Patient</a>
            <a href="{{ url('admin/invoices/print/'. $invoice->id) }}" class="btn btn-success pull-right ml-5" target="_blank"><i class="fa fa-newspaper-o"></i> Print ($)</a> <p></p>
            <a href="{{ url('admin/invoices/print/'. $invoice->id) }}?riels=1" class="btn btn-info pull-right p-3" target="_blank"><i class="fa fa-newspaper-o"></i> Print (R)</a>
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
