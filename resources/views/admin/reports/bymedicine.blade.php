@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Reports by Medicines</h3>



    <div class="panel panel-default">
        <div class="panel-heading">
           <b>From {{date_format(new DateTime($fromdate),"d-M-Y")}} to {{date_format(new DateTime($todate),"d-M-Y")}} </b>
        </div>


        <div class="panel-body table-responsive">


            <table class="table table-bordered table-striped {{ count($medicines) > 0 ? 'datatable' : '' }} @can('patient_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                <tr>
                    <th></th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>QTY</th>
                    <th>Org Price ($)</th>
                    <th>Ext Price ($)</th>

                    @php
                    $from= new DateTime($fromdate);
                    $to=new DateTime($todate);

                    for ($i=$from;$i<=$to;date_add($i, date_interval_create_from_date_string('1 days'))) {
                        echo '<th>'. date_format($i, 'd') . '</th>';
                    }
                    @endphp

                </tr>
                </thead>

                <tbody>
                @if (count($invoices) > 0)
                    @foreach ($medicines as $medicine)
                        @if ($medicine->invoices()->whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->count() > 0)

                            <tr data-entry-id="{{$medicine->id}}">
                                <td></td>

                                <td field-key='description'>{{$medicine->name}}</td>
                                <td field-key='unit'>{{$medicine->type}}</td>

                                <!-- Sum By Medicine for Qty -->
                                @php
                                  $invs=$medicine->invoices()->whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->get();
                                  //$invs=$invoices;
                                  $tbm=0;
                                  foreach ($invs as $inv){
                                    $qty=$inv->invoicedetail->where('medicine_id',$medicine->id)->sum('qty');
                                    $tbm += (int)$qty;
                                  }
                                  echo  "<td>".$tbm .'</td>';
                                @endphp

                                <td field-key='org_price'>{{$medicine->price}}</td>
                                <td field-key='ext_price'>{{$medicine->extend_price}}</td>


                                <!-- Sum By Day for Qty -->
                                @php
                                    $f= new DateTime($fromdate);
                                    $t=new DateTime($todate);

                                for($i=$f;$i<=$t;date_add($i, date_interval_create_from_date_string('1 days'))){
                                  $invs=$medicine->invoices()->where('date',$i)->whereIn('invstate_id',$invstates)->get();
                                  $tbd=0;
                                  foreach ($invs as $inv){
                                    $qty=$inv->invoicedetail->where('medicine_id',$medicine->id)->sum('qty');
                                    $tbd += (int)$qty;
                                  }
                                  echo  '<td>'.$tbd .'</td>';
                                }
                                @endphp


                            </tr>

                        @endif

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
    @parent

    <script>


    </script>
@stop