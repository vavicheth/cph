@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Reports by Departments</h3>



    <div class="panel panel-default">
        <div class="panel-heading">
            <b>From {{date_format(new DateTime($fromdate),"d-M-Y")}} to {{date_format(new DateTime($todate),"d-M-Y")}} </b>
        </div>


        <div class="panel-body table-responsive">

            <table class="table table-bordered table-striped {{ count($invoices) > 0 ? 'datatable' : '' }} @can('patient_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">

                <thead>
                <tr>
                    <th rowspan="2" ></th>
                    <th rowspan="2" style="text-align: center !important;">ផ្នែកព្យាបាល</th>
                    <th colspan="2" style="text-align: center !important;">បសស​ - ផ្នែកថែទាំសុខភាព</th>
                    <th colspan="2" style="text-align: center !important;">បសស​ - ផ្នែកគ្រោះថ្នាក់ការងារ</th>
                    <th colspan="2" style="text-align: center !important;">មូលនិធិសមធម៌ - OPD</th>
                    <th colspan="2" style="text-align: center !important;">មូលនិធិសមធម៌ - IPD</th>
                    <th rowspan="2" style="text-align: center !important;">ចំណាយថ្លៃដើម</th>
                    <th rowspan="2" style="text-align: center !important;">ចំនួនអ្នកជំងឺ</th>
                    <th rowspan="2" style="text-align: center !important;">តំលៃវិក្កយបត្រទៅបសស ($)</th>


                </tr>
                <tr>
                    <th style="text-align: center !important;">ចំនួនជំងឺ</th>
                    <th style="text-align: center !important;">តំលៃ ($)</th>
                    <th style="text-align: center !important;">ចំនួនជំងឺ</th>
                    <th style="text-align: center !important;">តំលៃ ($)</th>
                    <th style="text-align: center !important;">ចំនួនជំងឺ</th>
                    <th style="text-align: center !important;">តំលៃ ($)</th>
                    <th style="text-align: center !important;">ចំនួនជំងឺ</th>
                    <th style="text-align: center !important;">តំលៃ ($)</th>
                </tr>


                </thead>

                <tbody style="text-align: right !important;">
                @if (count($invoices) > 0)
                    @php
                        foreach ($departments as $department) {
                            echo "<tr data-entry-id='".$department->id."'>";
                            echo "<td></td>";
                            echo "<td field-key='date' style='text-align: left !important;'>".$department->name."</td>";

                            /* BS2 OPD */
                            $bs2_opd_count=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','1')->count();
                            echo "<td field-key='bs2_opd_count'>".$bs2_opd_count."</td>";
                             $bs2_opd_total=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','1')->sum('total');
                            echo "<td field-key='bs2_opd_total'>".number_format($bs2_opd_total,2)."</td>";

                            /* BS2 accident */
                            $bs2_accident_count=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','4')->count();
                            echo "<td field-key='bs2_accident_count'>".$bs2_accident_count."</td>";
                             $bs2_accident_total=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','4')->sum('total');
                            echo "<td field-key='bs2_ipd_total'>".number_format($bs2_accident_total,2)."</td>";



                            /* HEF OPD */
                            $hef_opd_count=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','3')->count();
                            echo "<td field-key='hef_opd_count'>".$hef_opd_count."</td>";
                             $hef_opd_total=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','3')->sum('total');
                            echo "<td field-key='hef_opd_total'>".number_format($hef_opd_total,2)."</td>";

                            /* HEF IPD */
                            $hef_ipd_count=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','2')->count();
                            echo "<td field-key='hef_ipd_count'>".$hef_ipd_count."</td>";
                             $hef_ipd_total=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->where('invstate_id','2')->sum('total');
                            echo "<td field-key='hef_ipd_total'>".number_format($hef_ipd_total,2)."</td>";


                            /* Total Original Price */
                            $invs=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->whereIn('invstate_id',['1','2','3','4'])->get();
                            $total_org_price=0;
                            foreach ($invs as $inv){
                                foreach ($inv->invoicedetail as $detail){
                                    $subtotal=$detail->qty * $detail->medicine->price;
                                    $total_org_price +=$subtotal;
                                }
                            }
                            echo "<td field-key='total_org_price'>".number_format($total_org_price,2)."</td>";


                            /* Count Patient */
                            $patient_count=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->whereIn('invstate_id',['1','2','3','4'])->count();
                            echo "<td field-key='forte_count'>".$patient_count."</td>";

                            /* Total Price */
                            $total_price=App\Invoice::whereBetween('date',[$fromdate,$todate])->where('department_id',$department->id)->whereIn('invstate_id',['1','2','3','4'])->sum('total');
                            echo "<td field-key='total_price'>".number_format($total_price,2)."</td>";




                            echo '</tr>';
                        }
                    @endphp
                @else
                    <tr>
                        <td colspan="13">@lang('quickadmin.qa_no_entries_in_table')</td>
                    </tr>
                @endif
                </tbody>

                <tfoot>
                <tr style="text-align: right !important;">
                    <td></td>
                    <td><b>Total:</b></td>
                    <td><b>{{$invoices->where('invstate_id','1')->count()}}</b></td>
                    <td><b>{{number_format($invoices->where('invstate_id','1')->sum('total'),2)}}</b></td>
                    <td><b>{{$invoices->where('invstate_id','4')->count()}}</b></td>
                    <td><b>{{number_format($invoices->where('invstate_id','4')->sum('total'),2)}}</b></td>
                    <td><b>{{$invoices->where('invstate_id','3')->count()}}</b></td>
                    <td><b>{{number_format($invoices->where('invstate_id','3')->sum('total'),2)}}</b></td>
                    <td><b>{{$invoices->where('invstate_id','2')->count()}}</b></td>
                    <td><b>{{number_format($invoices->where('invstate_id','2')->sum('total'),2)}}</b></td>

                    @php
                        $total=0;
                        foreach ($invoices as $invoice){
                            foreach ($invoice->invoicedetail as $invoicedetail){
                                $subtotal=$invoicedetail->qty * $invoicedetail->medicine->price;
                                $total +=$subtotal;
                            }
                        }
                        echo "<td><b>".number_format($total,2)."</b></td>";
                    @endphp

                    <td><b>{{$invoices->whereIn('invstate_id',['1','2','3','4'])->count()}}</b></td>
                    <td><b>{{number_format($invoices->whereIn('invstate_id',['1','2','3','4'])->sum('total'),2)}}</b></td>
                </tr>
                </tfoot>


            </table>
        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>


    </script>
@stop