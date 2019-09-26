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
//        if (! Gate::allows('patient_access')) {
////            return abort(401);
////        }
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

        if(request()->ajax()) {
//            return DataTables::of(Patient::query()->orderBy('id', 'DESC'))
            $patients=Patient::join('organizations','patients.oranization_id','=', 'organizations.id')
                ->join('users','patients.creator','=', 'users.id')
                ->join('invoices','patients.id','=', 'invoices.patient_id')
                ->select([
                    'patients.id as id',
                    'patients.name as name',
                    'patients.gender as gender',
                    'patients.age as age',
                    'patients.diagnostic as diagnostic',
                    'organizations.name_kh as organization',
                    'users.name as creator',
                    'invoices.created_at as date'
                ]);
            return DataTables::of($patients)
//            return DataTables::of(Patient::query())
                ->setRowId(function ($patient){
                    return $patient->id;
                })
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
                ->editColumn('age', function ($patient) {
                    return $patient->age ? $patient->age :'';
                })
                ->editColumn('diagnostic', function ($patient) {
                    return $patient->diagnostic ? $patient->diagnostic :'';
                })
                ->editColumn('gender', function ($patient) {
                    return $patient->gender == 1 ? 'Male':'Female';
                })
                ->filterColumn('gender', function ($query, $keyword) {
                    $query->whereRaw("patients.gender like ?", ["%$keyword%"]);
                })
                ->filterColumn('organization', function ($query, $keyword) {
                    $query->whereRaw("organizations.name_kh like ?", ["%$keyword%"]);
                })
                ->filterColumn('creator', function ($query, $keyword) {
                    $query->whereRaw("users.name like ?", ["%$keyword%"]);
                })
                ->editColumn('date', function ($patient){
                    return $patient->invoice->created_at->format('Y-m-d');
                })
                ->filterColumn('date', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(invoices.created_at,'%Y-%m-%d') like ?", ["%$keyword%"]);
                })


//                ->filterColumn('gender', function($query, $keyword) {
//                    return $query->whereRaw("gender) like ?", ["%{$keyword}%"]);
//                })
//                ->addColumn('organization', function (Patient $patient){
//                    return $patient->oranization->name_kh;
//                })
//                ->addColumn('creator', function (Patient $patient){
//                    return $patient->user_creator->name;
//                })
//                ->addColumn('date', function ($patient){
//                    return $patient->invoice->created_at->format('Y-m-d');
//                })
//                ->filterColumn('date', function ($query, $keyword) {
//                    $query->whereRaw("DATE_FORMAT(date,'%Y-%m-%d') like ?", ["%$keyword%"]);
//                })
////                ->filterColumn('oranization.name_kh', function ($query, $keyword) {
////                    $query->whereRaw("oranization.name_kh like ?", ["%$keyword%"]);
////                })
//                ->filterColumn('user_creator.name', function ($query, $keyword) {
//                    $query->whereRaw("user_creator.name like ?", ["%$keyword%"]);
//                })


                ->make(true);


        }

        return view('admin.patients.index');



    }

    public function getpatients()
    {
        $patients=Patient::findOrFail(2013)->orderBy('id', 'DESC')->with('oranization');
        return Datatables::of($patients)
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

            ->editColumn('created_at', function ($patient) {
                return $patient->updated_at->format('Y-m-d');
            })
            ->filterColumn('created_at', function ($patient, $keyword) {
                $patient->whereRaw("DATE_FORMAT(updated_at,'%Y-%m-%d') like ?", ["%$keyword%"]);
            })
            ->editColumn('gender', function ($patient) {
                if($patient->gender == 1){
                    return 'Male';
                }

                return 'Female';
            })
            ->filterColumn('created_at', function ($patient, $keyword) {
                $patient->where("gender", "like", ["%$keyword%"]);
            })

            ->editColumn('creator', function ($patient) {
                $user_creator=$patient->user_creator->name;
                return $user_creator;
            })
            ->filterColumn('creator', function ($patient, $keyword) {
                $patient->where("creator", "like", ["%$keyword%"]);
            })
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
