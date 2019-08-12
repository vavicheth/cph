<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Invoice;
use App\Invoicedetail;
use App\Invstate;
use App\Medicine;
use App\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{

    public function index(){

        $invstates=Invstate::orderBy('state','ASC')->pluck('state', 'id');
        $medicines=Medicine::where('active','=','1')->orderBy('name','ASC')->pluck('name', 'id');
        return view('admin.reports.index',compact('invstates','medicines'));
    }


    public function medicine(Request $request){

        $fromdate= date('Y-m-d',strtotime($request->fromdate));
        $todate=date('Y-m-d',strtotime($request->todate));

        $invstates=$request->invstate;
        if ($invstates==null){
            $invstates=Invstate::pluck('id');
        }

        $medicines=Medicine::get()->sortBy('name');
        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->get();

        return view('admin.reports.bymedicine', compact('medicines','invoices','fromdate','todate','invstates'));
    }

    public function date_report(Request $request){

        $fromdate= date('Y-m-d',strtotime($request->fromdate));
        $todate=date('Y-m-d',strtotime($request->todate));
        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->get();

        return view('admin.reports.bydate', compact('invoices','fromdate','todate'));
    }

    public function department(Request $request){

        $fromdate= date('Y-m-d',strtotime($request->fromdate));
        $todate=date('Y-m-d',strtotime($request->todate));
        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->get();
        $departments=Department::orderBy('name','ASC')->where('active','=','1')->get();

        return view('admin.reports.bydepartment', compact('invoices','fromdate','todate', 'departments'));
    }

    public function max_min(Request $request){

//        dd($request->all());

        $fromdate= date('Y-m-d',strtotime($request->fromdate));
        $todate=date('Y-m-d',strtotime($request->todate));
        $invstates=$request->invstate;
        if ($invstates==null){
            $invstates=Invstate::pluck('id');
        }

        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->get();
        $mi=$invoices->min('total');
        $ma=$invoices->max('total');

        $typereport='';

        if($request->type == 'min'){
            $typereport='Minimum';
            $invoices=$invoices->where('total','=',$mi);
        }elseif ($request->type == 'max'){
            $typereport='Maximum';
            $invoices=$invoices->where('total','=',$ma);
        }

        return view('admin.reports.maxandmin', compact('invoices','fromdate','todate','invstates','typereport'));
    }

    public function medicine_history(Request $request){

        $medicine=Medicine::findOrFail($request->medicine);
        $fromdate= date('Y-m-d',strtotime($request->fromdate));
        $todate=date('Y-m-d',strtotime($request->todate));

        $invoicedetails=Invoicedetail::whereBetween('created_at',[$fromdate,$todate])->where('medicine_id','=',$request->medicine)->get();

//        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->get();


        return view('admin.reports.medicine_history', compact('invoicedetails','fromdate','todate','medicine'));
    }

}
