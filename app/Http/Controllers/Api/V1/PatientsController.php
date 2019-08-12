<?php

namespace App\Http\Controllers\Api\V1;

use App\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatientsRequest;
use App\Http\Requests\Admin\UpdatePatientsRequest;

class PatientsController extends Controller
{
    public function index()
    {
        return Patient::all();
    }

    public function show($id)
    {
        return Patient::findOrFail($id);
    }

    public function update(UpdatePatientsRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
        

        return $patient;
    }

    public function store(StorePatientsRequest $request)
    {
        $patient = Patient::create($request->all());
        

        return $patient;
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return '';
    }
}
