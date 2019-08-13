<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Invoice;
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
        if (! Gate::allows('patient_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('patient_delete')) {
                return abort(401);
            }
            $patients = Patient::orderBy('id', 'DESC')->where('created_at', '>','2019-06-01' )->onlyTrashed()->get();
        } else {
            $patients = Patient::orderBy('id', 'DESC')->where('created_at', '>','2019-06-01' )->get();
        }

        return view('admin.patients.index');


//        if (request()->ajax()) {
//            $query = Patient::query();
//            $query->with("oranization");
//            $query->with("invoice");
//
//            $template = 'actionsTemplate';
//
//            $query->select([
//                'patients.id',
//                'patients.name',
//                'patients.gender',
//                'patients.age',
//                'patients.diagnostic',
//                'patients.contact',
//                'patients.description',
//                'patients.creator',
//                'patients.created_at',
//                'patients.oranization_id',
//
//            ]);
//            $table = Datatables::of($query);
//
//            $table->setRowAttr([
//                'data-entry-id' => '{{$id}}',
//            ]);
//            $table->addColumn('massDelete', '&nbsp;');
//            $table->addColumn('actions', '&nbsp;');
//            $table->editColumn('actions', function ($row) use ($template) {
//                $gateKey  = 'patient_';
//                $routeKey = 'admin.patients';
//
//                return view($template, compact('row', 'gateKey', 'routeKey'));
//            });
//            $table->editColumn('oranization.name_kh', function ($row) {
//                return $row->oranization ? $row->oranization->name_kh : '';
//            });
//            $table->editColumn('invoice.created_at', function ($row) {
//                return $row->invoice ? $row->invoice->created_at : '';
//            });
//
//
//            $table->rawColumns(['actions','massDelete']);
//
//            return $table->make(true);
//        }





    }

    public function getpatients()
    {
//        $patients=Patient::orderBy('id', 'DESC')->with('oranization');

//        $patients = Patient::query();
//        $patients->with("oranization");
//        $patients->with("invoice");

//        $patients->select([
//            'patients.id',
//            'patients.name',
//            'patients.gender',
//            'patients.age',
//            'patients.diagnostic',
//            'patients.contact',
//            'patients.description',
//            'patients.creator',
//            'patients.created_at',
//            'patients.oranization_id',
//        ]);

//        return Datatables::of($patients)

        $query = Patient::with('oranization')->select('patients.*');

        return DataTables::of($query)

            ->addColumn('action', function ($patient) {
                //view
                $v='<a href="'.route('admin.patients.show',$patient->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i>View</a> ';
                //edit
                $e='<a href="'.route('admin.patients.edit',$patient->id).'" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-edit"></i>Edit</a> ';
                //delete
                $d='<a href="javascript:;" data-toggle="modal" onclick="deleteData('. $patient->id.')"
                    data-target="#DeleteModal" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a>';

                $start=Carbon::parse($patient->created_at);
                $end=Carbon::now();
                $hour = $end->diffInHours($start);
                $duration_right=true;
                if ($hour > 24){
                    $duration_right=false;
                }

                if(Auth::user()->role->id == 1 || (Auth::user()->id == $patient->creator && $duration_right==True)){
                    if (Gate::allows('patient_delete')) {
                        return $v.$e.$d;
                    }else{
                        return $v;
                    }
                }else{
                    return $v;
                }

            })
//            ->addColumn('date', function ($patient) {
//                $d=$patient->invoice->date;
//                return date("Y-m-d", strtotime($d));
//            })
////            ->editColumn('oranization_id', function ($patient) {
////                $d=$patient->oranization->name_kh;
////                return $d;
////            })
//
//            ->editColumn('gender', function ($patient) {
//                if($patient->gender == 1){
//                    return 'Male';
//                }
//                return 'Female';
//            })
//            ->editColumn('creator', function ($patient) {
//                $user_creator=$patient->user_creator->name;
//                return $user_creator;
//            })
            ->make(true);
    }

    /**
     * Show the form for creating new Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }

        $oranizations = \App\Organization::orderBy('name_kh','ASC')->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $provinces = \App\Province::orderBy('province_en','ASC')->pluck('province_en', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $invstates=Invstate::orderBy('state','ASC')->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments=Department::orderBy('name','ASC')->where('active','=','1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.patients.create', compact('oranizations','provinces','invstates','departments'));
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param  \App\Http\Requests\StorePatientsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientsRequest $request)
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }

        $request->request->add(['creator' => Auth::user()->id]);

        $patient = Patient::create($request->all());

        $request['description']=$request['inv_description'];

        $invoice=$patient->invoices()->create($request->all());


//        foreach ($request->input('invoices', []) as $data) {
//            $patient->invoices()->create($data);
//        }

//        return redirect()->route('admin.patients.index');
        return redirect('admin/invoices/'. $invoice->id);
    }


    /**
     * Show the form for editing Patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }

        $oranizations = \App\Organization::orderBy('name_kh','ASC')->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $provinces = \App\Province::get()->pluck('province_en', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $patient = Patient::findOrFail($id);

        return view('admin.patients.edit', compact('patient', 'oranizations','provinces'));
    }

    /**
     * Update Patient in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientsRequest $request, $id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        $invoices           = $patient->invoices;
        $currentInvoiceData = [];
        foreach ($request->input('invoices', []) as $index => $data) {
            if (is_integer($index)) {
                $patient->invoices()->create($data);
            } else {
                $id                          = explode('-', $index)[1];
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('patient_view')) {
            return abort(401);
        }

        $oranizations = \App\Organization::get()->pluck('name_kh', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $invoices = \App\Invoice::where('patient_id', $id)->get();
        $patient = Patient::findOrFail($id);
        $invstates=Invstate::orderBy('state','ASC')->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments=Department::orderBy('name','ASC')->where('active','=','1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

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


        return view('admin.patients.show', compact('patient', 'invoices','invstates','departments'));
    }


    /**
     * Remove Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
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
        if (! Gate::allows('patient_delete')) {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->restore();

        return redirect()->route('admin.patients.index');
    }

    /**
     * Permanently delete Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->forceDelete();

        return redirect()->route('admin.patients.index');
    }
}
