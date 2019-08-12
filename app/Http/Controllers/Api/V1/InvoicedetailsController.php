<?php

namespace App\Http\Controllers\Api\V1;

use App\Invoicedetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInvoicedetailsRequest;
use App\Http\Requests\Admin\UpdateInvoicedetailsRequest;

class InvoicedetailsController extends Controller
{
    public function index()
    {
        return Invoicedetail::all();
    }

    public function show($id)
    {
        return Invoicedetail::findOrFail($id);
    }

    public function update(UpdateInvoicedetailsRequest $request, $id)
    {
        $invoicedetail = Invoicedetail::findOrFail($id);
        $invoicedetail->update($request->all());
        

        return $invoicedetail;
    }

    public function store(StoreInvoicedetailsRequest $request)
    {
        $invoicedetail = Invoicedetail::create($request->all());
        

        return $invoicedetail;
    }

    public function destroy($id)
    {
        $invoicedetail = Invoicedetail::findOrFail($id);
        $invoicedetail->delete();
        return '';
    }
}
