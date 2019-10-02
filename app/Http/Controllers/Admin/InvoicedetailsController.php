<?php

namespace App\Http\Controllers\Admin;

use App\Exchange;
use App\Extend;
use App\Invoice;
use App\Invoicedetail;
use App\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInvoicedetailsRequest;
use App\Http\Requests\Admin\UpdateInvoicedetailsRequest;

class InvoicedetailsController extends Controller
{
    /**
     * Display a listing of Invoicedetail.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('invoicedetail_access')) {
            return abort(401);
        }

        $from = date('2019-08-20');
        $to = date('2019-09-01');

//        $invoicedetails = Invoicedetail::limit(10)->get();
        $invoicedetails = Invoicedetail::whereBetween('created_at', [$from, $to])->get();

        return view('admin.invoicedetails.index', compact('invoicedetails'));
    }

    /**
     * Show the form for creating new Invoicedetail.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('invoicedetail_create')) {
            return abort(401);
        }
        
        $invoices = \App\Invoice::get()->pluck('date', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $medicines = \App\Medicine::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.invoicedetails.create', compact('invoices', 'medicines'));
    }

    /**
     * Store a newly created Invoicedetail in storage.
     *
     * @param  \App\Http\Requests\StoreInvoicedetailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoicedetailsRequest $request)
    {
        if (! Gate::allows('invoicedetail_create')) {
            return abort(401);
        }

        /**
         * Control duplicate medicine
         */

        $medicine=Medicine::findOrFail($request->medicine_id);
        $inv=Invoice::findOrFail($request->invoice_id);
        $md=$inv->invoicedetail->where('medicine_id','=',$request->medicine_id);
        $extend=Extend::whereDefault(1)->first();
        $exchange=Exchange::whereDefault(1)->first();

        $request->request->add(['extend_id' => $extend->id,'org_price'=>$medicine->price,'exchange_id'=>$exchange->id]);

        if (isset($md) && count($md) > 0){
//            $nd=$request->all();
            $md=$md->first();
            $request['qty']=$request['qty'] + $md['qty'];
            $total=$medicine->extend_price * $request->qty;
            $request->request->add(['type' => $medicine->type,'unit_price'=>$medicine->extend_price,'total'=>$total]);
            $md->update($request->all());

        }else{
            $total=$medicine->extend_price * $request->qty;
            $request->request->add(['type' => $medicine->type,'unit_price'=>$medicine->extend_price,'total'=>$total]);
            $invoicedetail = Invoicedetail::create($request->all());
        }


        $invoice=Invoice::findOrFail($request->invoice_id);
        $invoice->update(['total'=>$invoice->invoicedetail->sum('total')]);


        return redirect()->back();
    }


    /**
     * Show the form for editing Invoicedetail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('invoicedetail_edit')) {
            return abort(401);
        }
        
        $invoices = \App\Invoice::get()->pluck('date', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $medicines = \App\Medicine::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $invoicedetail = Invoicedetail::findOrFail($id);

        return view('admin.invoicedetails.edit', compact('invoicedetail', 'invoices', 'medicines'));
    }

    /**
     * Update Invoicedetail in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoicedetailsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoicedetailsRequest $request, $id)
    {
        if (! Gate::allows('invoicedetail_edit')) {
            return abort(401);
        }

        $medicine=Medicine::findOrFail($request->medicine_id);
        $inv=Invoice::findOrFail($request->invoice_id);
        $invoicedetail=$inv->invoicedetail->where('medicine_id','=',$request->medicine_id)->first();
        $extend=Extend::whereDefault(1)->first();
        $exchange=Exchange::whereDefault(1)->first();

        $request->request->add(['extend_id' => $extend->id,'org_price'=>$medicine->price,'exchange_id'=>$exchange->id]);

        $total=$medicine->extend_price * $request->qty;
        $request->request->add(['type' => $medicine->type,'unit_price'=>$medicine->extend_price,'total'=>$total]);
        $invoicedetail->update($request->all());


//        $invoicedetail = Invoicedetail::findOrFail($id);
//        $invoicedetail->update($request->all());
        $invoice=Invoice::findOrFail($request->invoice_id);
        $invoice->update(['total'=>$invoice->invoicedetail->sum('total')]);



        return redirect()->route('admin.invoices.show',$invoice);
    }


    /**
     * Display Invoicedetail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('invoicedetail_view')) {
            return abort(401);
        }
        $invoicedetail = Invoicedetail::findOrFail($id);

        return view('admin.invoicedetails.show', compact('invoicedetail'));
    }


    /**
     * Remove Invoicedetail from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('invoicedetail_delete')) {
            return abort(401);
        }
        $invoicedetail = Invoicedetail::findOrFail($id);
        $invoice=$invoicedetail->invoice;
        $invoicedetail->delete();

        $invoice->update(['total'=>$invoice->invoicedetail->sum('total')]);

//        $invoicedetails = \App\Invoicedetail::where('invoice_id', $invoice->id)->get();
//
//        $medicines=Medicine::get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

//        return view('admin.invoices.show', compact('invoice', 'medicines','invoicedetails'));
        return redirect()->back();
    }

    /**
     * Delete all selected Invoicedetail at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('invoicedetail_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Invoicedetail::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
