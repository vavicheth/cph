<?php

namespace App\Http\Controllers\Admin;

use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationsRequest;
use App\Http\Requests\Admin\UpdateOrganizationsRequest;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of Organization.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('organization_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('organization_delete')) {
                return abort(401);
            }
            $organizations = Organization::onlyTrashed()->get();
        } else {
            $organizations = Organization::all();
        }

        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating new Organization.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('organization_create')) {
            return abort(401);
        }
        return view('admin.organizations.create');
    }

    /**
     * Store a newly created Organization in storage.
     *
     * @param  \App\Http\Requests\StoreOrganizationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationsRequest $request)
    {
        if (! Gate::allows('organization_create')) {
            return abort(401);
        }
        $organization = Organization::create($request->all());



        return redirect()->route('admin.organizations.index');
    }


    /**
     * Show the form for editing Organization.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('organization_edit')) {
            return abort(401);
        }
        $organization = Organization::findOrFail($id);

        return view('admin.organizations.edit', compact('organization'));
    }

    /**
     * Update Organization in storage.
     *
     * @param  \App\Http\Requests\UpdateOrganizationsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationsRequest $request, $id)
    {
        if (! Gate::allows('organization_edit')) {
            return abort(401);
        }
        $organization = Organization::findOrFail($id);
        $organization->update($request->all());



        return redirect()->route('admin.organizations.index');
    }


    /**
     * Display Organization.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('organization_view')) {
            return abort(401);
        }
        $patients = \App\Patient::where('oranization_id', $id)->get();

        $organization = Organization::findOrFail($id);

        return view('admin.organizations.show', compact('organization', 'patients'));
    }


    /**
     * Remove Organization from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('organization_delete')) {
            return abort(401);
        }
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return redirect()->route('admin.organizations.index');
    }

    /**
     * Delete all selected Organization at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('organization_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Organization::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Organization from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('organization_delete')) {
            return abort(401);
        }
        $organization = Organization::onlyTrashed()->findOrFail($id);
        $organization->restore();

        return redirect()->route('admin.organizations.index');
    }

    /**
     * Permanently delete Organization from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('organization_delete')) {
            return abort(401);
        }
        $organization = Organization::onlyTrashed()->findOrFail($id);
        $organization->forceDelete();

        return redirect()->route('admin.organizations.index');
    }
}
