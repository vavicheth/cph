@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Reports by Medicine History</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            <b>From {{date_format(new DateTime($fromdate),"d-M-Y")}} to {{date_format(new DateTime($todate),"d-M-Y")}} </b>
        </div>

        <div class="panel-body table-responsive">
            {{$medicine->name}}
            <table class="table table-bordered table-striped {{ count($invoicedetails) > 0 ? 'datatable' : '' }} ">
                <thead>
                <tr>
                    <th>@lang('quickadmin.patients.fields.name')</th>
                    <th>@lang('quickadmin.patients.fields.gender')</th>
                    <th>@lang('quickadmin.patients.fields.age')</th>
                    <th>@lang('quickadmin.patients.fields.diagnostic')</th>
                    <th>Invoice State</th>
                    <th>Department</th>
                    <th>Creator</th>
                    <th>Date</th>
                    <th>Total ($)</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @if (count($invoicedetails) > 0)
                    @foreach ($invoicedetails as $invoicedetail)
                        <tr data-entry-id="{{ $invoicedetail->invoice->id }}">
                            <td field-key='name'>{{ $invoicedetail->invoice->patient->name }}</td>
                            <td field-key='gender'>{{ $invoicedetail->invoice->patient->gender  == 1 ? 'Male' : 'Female' }}</td>
                            <td field-key='age'>{{ $invoicedetail->invoice->patient->age }}</td>
                            <td field-key='diagnostic'>{{ $invoicedetail->invoice->patient->diagnostic }}</td>
                            <td field-key='oranization'>{{ $invoicedetail->invoice->invstate->state ?? '' }}</td>
                            <td field-key='department'>{{ $invoicedetail->invoice->department->name?? '' }}</td>
                            <td field-key='creator'>{{ $invoicedetail->invoice->user_creator->name?? '' }}</td>
                            <td field-key='date'>{{date('Y-m-d', strtotime($invoicedetail->invoice->date))}}</td>
                            <td field-key='total' style="text-align: right">{{ $invoicedetail->invoice->total }}</td>
                            <td>
                                <a href="{{ route('admin.invoices.show',[$invoicedetail->invoice->id]) }}" class="btn btn-xs btn-primary">View Invoice</a>
                            </td>
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
@stop

@section('javascript')
    <script>


    </script>
@endsection