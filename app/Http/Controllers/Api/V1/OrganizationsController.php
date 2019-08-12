<?php

namespace App\Http\Controllers\Api\V1;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationsRequest;
use App\Http\Requests\Admin\UpdateOrganizationsRequest;

class OrganizationsController extends Controller
{
    public function index()
    {
        return Organization::all();
    }

    public function show($id)
    {
        return Organization::findOrFail($id);
    }

    public function update(UpdateOrganizationsRequest $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->update($request->all());
        

        return $organization;
    }

    public function store(StoreOrganizationsRequest $request)
    {
        $organization = Organization::create($request->all());
        

        return $organization;
    }

    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return '';
    }
}
