<?php

namespace App\Http\Controllers\Admin;

use App\Invstate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class InvstatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('invstate_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('invstate_delete')) {
                return abort(401);
            }
            $invstates = Invstate::onlyTrashed()->get();
        } else {
            $invstates = Invstate::all();
        }

        return view('admin.invstates.index', compact('invstates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('invstate_create')) {
            return abort(401);
        }
        return view('admin.invstates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('invstate_create')) {
            return abort(401);
        }
        $invstate = Invstate::create($request->all());



        return redirect()->route('admin.invstates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('invstate_view')) {
            return abort(401);
        }

        $invstate = Invstate::findOrFail($id);

        return view('admin.invstates.show', compact('invstate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('invstate_edit')) {
            return abort(401);
        }
        $invstate = Invstate::findOrFail($id);

        return view('admin.invstates.edit', compact('invstate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('invstate_edit')) {
            return abort(401);
        }
        $invstate = Invstate::findOrFail($id);
        $invstate->update($request->all());

        return redirect()->route('admin.invstates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('invstate_delete')) {
            return abort(401);
        }
        $invstate = Invstate::findOrFail($id);
        $invstate->delete();

        return redirect()->route('admin.invstates.index');
    }

    /**
     * Remove the multi resource from storage.
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('invstate_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Invstate::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore resource from deleted.
     */
    public function restore($id)
    {
        if (! Gate::allows('invstate_delete')) {
            return abort(401);
        }
        $invstate = Invstate::onlyTrashed()->findOrFail($id);
        $invstate->restore();

        return redirect()->route('admin.invstates.index');
    }


    /**
     * Remove resource permanent from storage.
     */
    public function perma_del($id)
    {
        if (! Gate::allows('invstate_delete')) {
            return abort(401);
        }
        $invstate = Invstate::onlyTrashed()->findOrFail($id);
        $invstate->forceDelete();

        return redirect()->route('admin.invstates.index');
    }
}
