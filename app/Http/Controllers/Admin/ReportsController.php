<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Invoice;
use App\Invoicedetail;
use App\Invstate;
use App\Medicine;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{

    public function index()
    {

        $invstates = Invstate::orderBy('state', 'ASC')->pluck('state', 'id');
        $medicines = Medicine::where('active', '=', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
        $departments = Department::where('active', '=', '1')->orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.reports.index', compact('invstates', 'medicines', 'departments'));
    }


    public function medicine(Request $request)
    {
//        set_time_limit(0);
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        $invstates = $request->invstate;
//        if ($invstates==null){
//            $invstates=Invstate::pluck('id');
//        }
//        $medicines=Medicine::get()->sortBy('name');
//        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->get();

//        $show_all = array(
//            'Day' => array('Monday' => 'A','Tuesday' => 'B','Wednesday' => 'C',),
//            'Month' => array('Jan' => 'A','Feb' => 'B','Mar' => 'C',),
//
//        );

        $d=Department::all();
        dd($d);

        $show_all=array('Medicine'=>[],'Type'=>[]);
//        $i=Carbon::parse($fromdate)->day;
//        dd($i);

        while (strtotime($fromdate) <= strtotime($todate)) {
            $i="";
            $i=Carbon::parse($fromdate)->day;

            $show_all = $show_all + array($i=>[]);
            $fromdate = date ("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }

//        $show_all=[];
//
//        for ($i=$fromdate;$i<=$todate;date_add($i, date_interval_create_from_date_string('1 days'))) {
//            $show_all = array(
//                $i,
//            );
//        }
//
        dd($show_all);
//
//
//        return view('admin.reports.bymedicine', compact('medicines', 'invoices', 'fromdate', 'todate', 'invstates'));
    }

    public function date_report(Request $request)
    {
        set_time_limit(0);

        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        $invoices = Invoice::whereBetween('date', [$fromdate, $todate])->get();

        return view('admin.reports.bydate', compact('invoices', 'fromdate', 'todate'));
    }

    public function department(Request $request)
    {
        set_time_limit(0);

        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        $invoices = Invoice::whereBetween('date', [$fromdate, $todate])->get();
        $departments = Department::orderBy('name', 'ASC')->where('active', '=', '1')->get();

        return view('admin.reports.bydepartment', compact('invoices', 'fromdate', 'todate', 'departments'));
    }

    public function max_min(Request $request)
    {
        set_time_limit(0);

        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        $invstates = $request->invstate;
        if ($invstates == null) {
            $invstates = Invstate::pluck('id');
        }

        $invoices = Invoice::whereBetween('date', [$fromdate, $todate])->whereIn('invstate_id', $invstates)->get();
        $mi = $invoices->min('total');
        $ma = $invoices->max('total');

        $typereport = '';

        if ($request->type == 'min') {
            $typereport = 'Minimum';
            $invoices = $invoices->where('total', '=', $mi);
        } elseif ($request->type == 'max') {
            $typereport = 'Maximum';
            $invoices = $invoices->where('total', '=', $ma);
        }

        return view('admin.reports.maxandmin', compact('invoices', 'fromdate', 'todate', 'invstates', 'typereport'));
    }

    public function medicine_history(Request $request)
    {
        set_time_limit(0);

        $medicine = Medicine::findOrFail($request->medicine);
        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));

        $invoicedetails = Invoicedetail::whereBetween('created_at', [$fromdate, $todate])->where('medicine_id', '=', $request->medicine)->get();

//        $invoices=Invoice::whereBetween('date',[$fromdate,$todate])->whereIn('invstate_id',$invstates)->get();


        return view('admin.reports.medicine_history', compact('invoicedetails', 'fromdate', 'todate', 'medicine'));
    }

    public function department_patient(Request $request)
    {
        set_time_limit(0);

        $fromdate = date('Y-m-d', strtotime($request->fromdate));
        $todate = date('Y-m-d', strtotime($request->todate));
        $department = $request->department;
        if ($department == null) {
            $department = Department::pluck('id');
        }
        $departmentname = Department::findOrFail($department)->name;

        $invoices = Invoice::whereBetween('date', [$fromdate, $todate])->where('department_id', $department)->get();


        return view('admin.reports.department_patient', compact('invoices', 'fromdate', 'todate', 'department', 'departmentname'));
    }

}
