<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Exchange;
use App\Invoice;
use App\Invstate;
use App\Medicine;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInvoicesRequest;
use App\Http\Requests\Admin\UpdateInvoicesRequest;

class InvoicesController extends Controller
{
    /**
     * Display a listing of Invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('invoice_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('invoice_delete')) {
                return abort(401);
            }
            $invoices = Invoice::onlyTrashed()->get();
        } else {
            $invoices = Invoice::all();
        }

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating new Invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('invoice_create')) {
            return abort(401);
        }
        
        $patients = \App\Patient::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.invoices.create', compact('patients'));
    }

    /**
     * Store a newly created Invoice in storage.
     *
     * @param  \App\Http\Requests\StoreInvoicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoicesRequest $request)
    {
        if (! Gate::allows('invoice_create')) {
            return abort(401);
        }

        $request->request->add(['creator' => Auth::user()->id]);

        $invoice = Invoice::create($request->all());

        return redirect()->back();
    }


    /**
     * Show the form for editing Invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('invoice_edit')) {
            return abort(401);
        }
        
        $patients = \App\Patient::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $invoice = Invoice::findOrFail($id);
        $invstates=Invstate::get()->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments=Department::where('active','=','1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.invoices.edit', compact('invoice', 'patients','invstates','departments'));
    }

    /**
     * Update Invoice in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoicesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoicesRequest $request, $id)
    {
        if (! Gate::allows('invoice_edit')) {
            return abort(401);
        }

        $patient = Patient::findOrFail($request->patient_id);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        $invoices = \App\Invoice::where('patient_id', $request->patient_id)->get();
        $invstates=Invstate::get()->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments=Department::where('active','=','1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.patients.show', compact('patient','invoices','invstates','departments'));

    }


    /**
     * Display Invoice.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('invoice_view')) {
            return abort(401);
        }
        
        $patients = \App\Patient::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $invoicedetails = \App\Invoicedetail::where('invoice_id', $id)->get();

        $invoice = Invoice::findOrFail($id);
        $medicines=Medicine::orderBy('name','ASC')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');


        /**
         * Duration to delete for users
         */
        $start=Carbon::parse($invoice->created_at);
        $end=Carbon::now();
        $hour = $end->diffInHours($start);
        $duration_right=true;
        if ($hour > 24){
            $duration_right=false;
        }


        return view('admin.invoices.show', compact('invoice', 'invoicedetails','medicines','duration_right'));
    }


    /**
     * Remove Invoice from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('invoice_delete')) {
            return abort(401);
        }
        $invoice = Invoice::findOrFail($id);
        $patient=$invoice->patient;
        $invoice->delete();

        $invoices = \App\Invoice::where('patient_id', $id)->get();
        $invstates=Invstate::get()->pluck('state', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $departments=Department::where('active','=','1')->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

//        return view('admin.patients.show', compact('patient', 'invoices','invstates','departments'));
        return redirect()->back();


    }

    /**
     * Delete all selected Invoice at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('invoice_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Invoice::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Invoice from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('invoice_delete')) {
            return abort(401);
        }
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->restore();

        return redirect()->route('admin.invoices.index');
    }

    /**
     * Permanently delete Invoice from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('invoice_delete')) {
            return abort(401);
        }
        $invoice = Invoice::onlyTrashed()->findOrFail($id);
        $invoice->forceDelete();

        return redirect()->route('admin.invoices.index');
    }

    public function print($id)
    {
        if (! Gate::allows('invoice_view')) {
            return abort(401);
        }
        $invoice = Invoice::findOrFail($id);
        $invoicedetails=$invoice->invoicedetail;
        $patient=$invoice->patient;

        $exchange=Exchange::whereDefault(1)->first();

        $nm =Carbon::parse($invoice->date)->format('m');
        $nm = (int)$nm;

        $m_kh= '';

        switch( $nm ) {
            case '1': $m_kh= 'មករា' ; break;
            case '2': $m_kh= 'កុម្ភៈ' ; break;
            case '3': $m_kh= 'មីនា' ; break;
            case '4': $m_kh= 'មេសា' ; break;
            case '5': $m_kh= 'ឧសភា' ; break;
            case '6': $m_kh= 'មិថុនា' ; break;
            case '7': $m_kh= 'កក្កដា' ; break;
            case '8': $m_kh= 'សីហា' ; break;
            case '9': $m_kh= 'កញ្ញា' ; break;
            case '10': $m_kh= 'តុលា' ; break;
            case '11': $m_kh= 'វិច្ឆិកា' ; break;
            case '12': $m_kh= 'ធ្នូ' ; break;
        }

        if (request('riels') == 1){
            return view('admin.invoices.print_riels',compact('invoice','invoicedetails','patient','m_kh','exchange'));
        }
            return view('admin.invoices.print',compact('invoice','invoicedetails','patient','m_kh','exchange'));
    }


}
