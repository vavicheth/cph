<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Invoice;
use App\Invoicedetail;
use App\Invstate;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatientsRequest;
use App\Http\Requests\Admin\UpdatePatientsRequest;
use Yajra\DataTables\DataTables;

class PatientsController extends Controller
{
    /**
     * Display a listing of Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('patient_access')) {
            return abort(401);
        }
////        if (request('show_deleted') == 1) {
////            if (! Gate::allows('patient_delete')) {
////                return abort(401);
////            }
////            $patients = Patient::orderBy('id', 'DESC')->where('created_at', '>','2019-06-01' )->onlyTrashed()->get();
////        } else {
////            $patients = Patient::orderBy('id', 'DESC')->where('created_at', '>','2019-06-01' )->get();
////        }
////        return view('admin.patients.index', compact('patients'));

//        if (request('show_deleted') == 1) {
//            if (! Gate::allows('patient_delete')) {
//                return abort(401);
//            }
////            dd('test');
//            $patient = datatables()->of(Patient::select('*')->orderBy('id', 'DESC')->onlyTrashed());
//        } else {
//            $patient = datatables()->of(Patient::select('*')->orderBy('id', 'DESC')->with('oranization','user_creator'));
//        }

//        if (request('show_deleted') == 1) {
//            if (!Gate::allows('patient_delete')) {
//                return abort(401);
//            }
//            $patients = Patient::
//                join('organizations', 'patients.oranization_id', '=', 'organizations.id')
//                ->join('users', 'patients.creator', '=', 'users.id')
//                ->join('invoices', 'patients.id', '=', 'invoices.patient_id')
//                ->select([
//                    'patients.id as id',
//                    'patients.name as name',
//                    'patients.gender as gender',
//                    'patients.age as age',
//                    'patients.diagnostic as diagnostic',
//                    'organizations.name_kh as organization',
//                    'users.name as creator',
//                    'invoices.date as date'
//                ]);
//            $patients = $patients->onlyTrashed();
//        }else{
//            $patients = Patient::join('organizations', 'patients.oranization_id', '=', 'organizations.id')
//                ->join('users', 'patients.creator', '=', 'users.id')
//                ->join('invoices', 'patients.id', '=', 'invoices.patient_id')
//                ->select([
//                    'patients.id as id',
//                    'patients.name as name',
//                    'patients.gender as gender',
//                    'patients.age as age',
//                    'patients.diagnostic as diagnostic',
//                    'organizations.name_kh as organization',
//                    'users.name as creator',
//                    'invoices.date as date'
//                ]);
//            $patients = $patients->onlyTrashed();
//        }


        if (request()->ajax()) {
            $patients = Patient::
            join('organizations', 'patients.oranization_id', '=', 'organizations.id')
                ->join('users', 'patients.creator', '=', 'users.id')
                ->join('invoices', 'patients.id', '=', 'invoices.patient_id')
                ->select([
                    'patients.id as id',
                    'patients.name as name',
                    'patients.gender as gender',
                    'patients.age as age',
                    'patients.diagnostic as diagnostic',
                    'patients.creator as creator',
                    'organizations.name_kh as organization',
                    'users.name as usercreator',
                    'invoices.date as date'
                ]);

            if (request('show_deleted') == 1) {
                if (!Gate::allows('patient_delete')) {
                    return abort(401);
                }
                $patients = $patients->onlyTrashed();
            }

            return DataTables::of($patients)
                ->setRowId(function ($patient) {
                    return $patient->id;
                })
                ->addColumn('action', function ($patient) {

                    //view
                    $v = '<a href="' . route('admin.patients.show', $patient->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i>View</a> ';
                    //edit
                    $e = '<a href="' . route('admin.patients.edit', $patient->id) . '" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-edit"></i>Edit</a> ';
                    //delete
                    $d = '<a href="javascript:;" data-toggle="modal" onclick="deleteData(' . $patient->id . ')"
                    data-target="#DeleteModal" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a>';
                    //permanent_delete
                    $dp = '<a href="javascript:;" data-toggle="modal" onclick="deleteDataPerma(' . $patient->id . ')"
                    data-target="#DeleteModalPerma" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete Permanent</a>';
                    //restore
                    $r = '<a href="javascript:;" data-toggle="modal" onclick="restoreData(' . $patient->id . ')"
                    data-target="#RestoreModal" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-backward"></i> Restore</a>';


                    $start = Carbon::parse($patient->created_at);
                    $end = Carbon::now();
                    $hour = $end->diffInHours($start);
                    $duration_right = true;
                    if ($hour > 24) {
                        $duration_right = false;
                    }


                    if (Auth::user()->role->id == 1 || (Auth::user()->id == $patient->creator && $duration_right == True)) {

                        if (Gate::allows('patient_delete')) {
                            if (request('show_deleted') == 1) {
                                return $r . ' ' . $dp;
                            } else {
                                return $v . $e . $d;
                            }

                        } else {
                            return $v;
                        }
                    } else {
                        return $v;
                    }

                })
                ->editColumn('age', function ($patient) {
                    return $patient->age ? $patient->age : '';
                })
                ->editColumn('diagnostic', function ($patient) {
                    return $patient->diagnostic ? $patient->diagnostic : '';
                })
                ->editColumn('gender', function ($patient) {
                    return $patient->gender == 1 ? 'Male' : 'Female';
                })
                ->filterColumn('gender', function ($query, $keyword) {
                    $query->whereRaw("IF(gender = 1, 'Male', 'Female') like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('organization', function ($query, $keyword) {
                    $query->whereRaw("organizations.name_kh like ?", ["%$keyword%"]);
                })
                ->filterColumn('usercreator', function ($query, $keyword) {
                    $query->whereRaw("users.name like ?", ["%$keyword%"]);
                })
//                ->editColumn('date', function ($patient){
//                    return $patient->invoice->date->format('Y-m-d');
//                })
                ->filterColumn('date', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(invoices.date,'%Y-%m-%d') like ?", ["%$keyword%"]);
                })
                ->make(true);


        }
        return view('admin.patients.index');

    }


    /**
     * Show the form for creating new Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('patient_create')) {
            return abort(401);
        }

        $oranizations = \App\Organization::orderBy('name_kh', 'ASC')->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $provinces = \App\Province::orderBy('province_en', 'ASC')->pluck('province_en', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $invstates = Invstate::orderBy('state', 'ASC')->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments = Department::orderBy('name', 'ASC')->where('active', '=', '1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.patients.create', compact('oranizations', 'provinces', 'invstates', 'departments'));
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param \App\Http\Requests\StorePatientsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientsRequest $request)
    {
        if (!Gate::allows('patient_create')) {
            return abort(401);
        }

        $request->request->add(['creator' => Auth::user()->id]);

        $patient = Patient::create($request->all());

        $request['description'] = $request['inv_description'];

        $invoice = $patient->invoices()->create($request->all());


//        foreach ($request->input('invoices', []) as $data) {
//            $patient->invoices()->create($data);
//        }

//        return redirect()->route('admin.patients.index');
        return redirect('admin/invoices/' . $invoice->id);
    }


    /**
     * Show the form for editing Patient.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('patient_edit')) {
            return abort(401);
        }

        $oranizations = \App\Organization::orderBy('name_kh', 'ASC')->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $provinces = \App\Province::get()->pluck('province_en', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $patient = Patient::findOrFail($id);

        return view('admin.patients.edit', compact('patient', 'oranizations', 'provinces'));
    }

    /**
     * Update Patient in storage.
     *
     * @param \App\Http\Requests\UpdatePatientsRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientsRequest $request, $id)
    {
        if (!Gate::allows('patient_edit')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        $invoices = $patient->invoices;
        $currentInvoiceData = [];
        foreach ($request->input('invoices', []) as $index => $data) {
            if (is_integer($index)) {
                $patient->invoices()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentInvoiceData[$id] = $data;
            }
        }
        foreach ($invoices as $item) {
            if (isset($currentInvoiceData[$item->id])) {
                $item->update($currentInvoiceData[$item->id]);
            } else {
                $item->delete();
            }
        }


        return redirect()->route('admin.patients.index');
    }


    /**
     * Display Patient.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('patient_view')) {
            return abort(401);
        }

        $oranizations = \App\Organization::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $invoices = \App\Invoice::where('patient_id', $id)->get();
        $patient = Patient::findOrFail($id);
        $invstates = Invstate::orderBy('state', 'ASC')->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments = Department::orderBy('name', 'ASC')->where('active', '=', '1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        /**
         * Duration to delete for users
         */
//        $start=Carbon::parse($invoice->created_at);
//        $end=Carbon::now();
//        $hour = $end->diffInHours($start);
//        $duration_right=true;
//        if ($hour > 24){
//            $duration_right=false;
//        }


        return view('admin.patients.show', compact('patient', 'invoices', 'invstates', 'departments'));
    }


    /**
     * Remove Patient from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
        $invoices = $patient->invoices;
        foreach ($invoices as $invoice) {
            $invoicedetails = Invoicedetail::where('invoice_id', '=', $invoice->id)->get();
            foreach ($invoicedetails as $invoicedetail) {
                $invoicedetail->delete();
            }
        }
        $patient->invoices()->delete();
        $patient->delete();


        return redirect()->route('admin.patients.index');
    }

    /**
     * Delete all selected Patient at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('patient_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Patient::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Patient from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $invoices = $patient->invoices()->onlyTrashed()->get();
        foreach ($invoices as $invoice) {
            $invoicedetails = Invoicedetail::onlyTrashed()->where('invoice_id', '=', $invoice->id)->get();
            foreach ($invoicedetails as $invoicedetail) {
                $invoicedetail->restore();
            }
        }
        $patient->invoices()->restore();
        $patient->restore();

        return redirect()->route('admin.patients.index');
    }

    /**
     * Permanently delete Patient from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $invoices = $patient->invoices()->onlyTrashed()->get();
        foreach ($invoices as $invoice) {
            $invoicedetails = Invoicedetail::onlyTrashed()->where('invoice_id', '=', $invoice->id)->get();
            foreach ($invoicedetails as $invoicedetail) {
                $invoicedetail->forceDelete();
            }
        }
        $patient->invoices()->forceDelete();
        $patient->forceDelete();

        return redirect()->route('admin.patients.index');
    }
}
