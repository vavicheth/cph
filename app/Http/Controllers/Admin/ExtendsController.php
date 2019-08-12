<?php

namespace App\Http\Controllers\Admin;

use App\Extend;
use App\Invoicedetail;
use App\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr\Cast\Int_;

class ExtendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('extend_access')) {
            return abort(401);
        }

        Medicine::all();

        $invds=Invoicedetail::where('org_price','=',null)->get();

        foreach ($invds as $invd){
//            dd($invd);
             $invd->update(['org_price'=>$invd->medicine->price]);
        }



        if (request('show_deleted') == 1) {
            if (! Gate::allows('extend_delete')) {
                return abort(401);
            }
            $extends = Extend::onlyTrashed()->get();
        } else {
            $extends = Extend::all();
        }

        return view('admin.extends.index', compact('extends'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('extend_create')) {
            return abort(401);
        }
        return view('admin.extends.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('extend_create')) {
            return abort(401);
        }
        $extend = Extend::create($request->all());



        return redirect()->route('admin.extends.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('extend_view')) {
            return abort(401);
        }

        $extend = Extend::findOrFail($id);

        return view('admin.extends.show', compact('extend'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('extend_edit')) {
            return abort(401);
        }
        $extend = Extend::findOrFail($id);

        return view('admin.extends.edit', compact('extend'));
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
        if (! Gate::allows('extend_edit')) {
            return abort(401);
        }
        $extend = Extend::findOrFail($id);
        $extend->update($request->all());

        return redirect()->route('admin.extends.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('extend_delete')) {
            return abort(401);
        }
        $extend = Extend::findOrFail($id);
        $extend->delete();

        return redirect()->route('admin.extends.index');
    }

    /**
     * Remove the multi resource from storage.
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('extend_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Extend::whereIn('id', $request->input('ids'))->get();

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
        if (! Gate::allows('extend_delete')) {
            return abort(401);
        }
        $extend = Extend::onlyTrashed()->findOrFail($id);
        $extend->restore();

        return redirect()->route('admin.extends.index');
    }


    /**
     * Remove resource permanent from storage.
     */
    public function perma_del($id)
    {
        if (! Gate::allows('extend_delete')) {
            return abort(401);
        }
        $extend = Extend::onlyTrashed()->findOrFail($id);
        $extend->forceDelete();

        return redirect()->route('admin.extends.index');
    }

    public function set_default(Request $request, $id)
    {
        if (! Gate::allows('extend_access')) {
            return abort(401);
        }

        Extend::where('default', '=', 1)->update(['default' => 0]);
        $extend=Extend::whereId($id);
        $extend_price=$extend->pluck('percentage')->first();

//        dd($extend_price);

        $extend->update(['default' => 1]);

        if ($request->manual == 1){
            $medicines=Medicine::all();
        }else{
            $medicines=Medicine::where('manual','=',0)->get();
        }

//        dd($medicines);

        foreach ($medicines as $medicine){
            $price=$medicine->price;
            $total= $price + (($extend_price * $price)/100);

            $medicine->update(['extend_price'=>$total]);

        }

        return redirect()->route('admin.extends.index');
    }


}
