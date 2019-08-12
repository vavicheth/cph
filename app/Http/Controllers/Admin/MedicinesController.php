<?php

namespace App\Http\Controllers\Admin;

use App\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicinesRequest;
use App\Http\Requests\Admin\UpdateMedicinesRequest;

class MedicinesController extends Controller
{
    /**
     * Display a listing of Medicine.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('medicine_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('medicine_delete')) {
                return abort(401);
            }
            $medicines = Medicine::onlyTrashed()->get();
        } else {
            $medicines = Medicine::all();
        }

        return view('admin.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating new Medicine.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('medicine_create')) {
            return abort(401);
        }
        return view('admin.medicines.create');
    }

    /**
     * Store a newly created Medicine in storage.
     *
     * @param  \App\Http\Requests\StoreMedicinesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicinesRequest $request)
    {
        if (! Gate::allows('medicine_create')) {
            return abort(401);
        }
        $medicine = Medicine::create($request->all());



        return redirect()->route('admin.medicines.index');
    }


    /**
     * Show the form for editing Medicine.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('medicine_edit')) {
            return abort(401);
        }
        $medicine = Medicine::findOrFail($id);

        return view('admin.medicines.edit', compact('medicine'));
    }

    /**
     * Update Medicine in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicinesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicinesRequest $request, $id)
    {
        if (! Gate::allows('medicine_edit')) {
            return abort(401);
        }
        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());



        return redirect()->route('admin.medicines.index');
    }


    /**
     * Display Medicine.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('medicine_view')) {
            return abort(401);
        }
        $invoicedetails = \App\Invoicedetail::where('medicine_id', $id)->get();

        $medicine = Medicine::findOrFail($id);

        return view('admin.medicines.show', compact('medicine', 'invoicedetails'));
    }


    /**
     * Remove Medicine from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('medicine_delete')) {
            return abort(401);
        }
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('admin.medicines.index');
    }

    /**
     * Delete all selected Medicine at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('medicine_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Medicine::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Medicine from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('medicine_delete')) {
            return abort(401);
        }
        $medicine = Medicine::onlyTrashed()->findOrFail($id);
        $medicine->restore();

        return redirect()->route('admin.medicines.index');
    }

    /**
     * Permanently delete Medicine from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('medicine_delete')) {
            return abort(401);
        }
        $medicine = Medicine::onlyTrashed()->findOrFail($id);
        $medicine->forceDelete();

        return redirect()->route('admin.medicines.index');
    }
}
