<?php

namespace App\Http\Controllers\Admin;

use App\Exchange;
use App\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr\Cast\Int_;

class ExchangesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('exchange_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('exchange_delete')) {
                return abort(401);
            }
            $exchanges = Exchange::onlyTrashed()->get();
        } else {
            $exchanges = Exchange::all();
        }

        return view('admin.exchanges.index', compact('exchanges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('exchange_create')) {
            return abort(401);
        }
        return view('admin.exchanges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('exchange_create')) {
            return abort(401);
        }
        $exchange = Exchange::create($request->all());



        return redirect()->route('admin.exchanges.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('exchange_view')) {
            return abort(401);
        }

        $exchange = Exchange::findOrFail($id);

        return view('admin.exchanges.show', compact('exchange'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('exchange_edit')) {
            return abort(401);
        }
        $exchange = Exchange::findOrFail($id);

        return view('admin.exchanges.edit', compact('exchange'));
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
        if (! Gate::allows('exchange_edit')) {
            return abort(401);
        }
        $exchange = Exchange::findOrFail($id);
        $exchange->update($request->all());

        return redirect()->route('admin.exchanges.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('exchange_delete')) {
            return abort(401);
        }
        $exchange = Exchange::findOrFail($id);
        $exchange->delete();

        return redirect()->route('admin.exchanges.index');
    }

    /**
     * Remove the multi resource from storage.
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('exchange_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Exchange::whereIn('id', $request->input('ids'))->get();

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
        if (! Gate::allows('exchange_delete')) {
            return abort(401);
        }
        $exchange = Exchange::onlyTrashed()->findOrFail($id);
        $exchange->restore();

        return redirect()->route('admin.exchanges.index');
    }


    /**
     * Remove resource permanent from storage.
     */
    public function perma_del($id)
    {
        if (! Gate::allows('exchange_delete')) {
            return abort(401);
        }
        $exchange = Exchange::onlyTrashed()->findOrFail($id);
        $exchange->forceDelete();

        return redirect()->route('admin.exchanges.index');
    }

    public function set_default(Request $request, $id)
    {
        if (! Gate::allows('exchange_edit')) {
            return abort(401);
        }

        Exchange::where('default', '=', 1)->update(['default' => 0]);
        $exchange=Exchange::findOrFail($id);
        $exchange->update(['default' => 1]);

        return redirect()->route('admin.exchanges.index');
    }


}
