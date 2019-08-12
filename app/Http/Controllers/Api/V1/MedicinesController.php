<?php

namespace App\Http\Controllers\Api\V1;

use App\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicinesRequest;
use App\Http\Requests\Admin\UpdateMedicinesRequest;

class MedicinesController extends Controller
{
    public function index()
    {
        return Medicine::all();
    }

    public function show($id)
    {
        return Medicine::findOrFail($id);
    }

    public function update(UpdateMedicinesRequest $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());
        

        return $medicine;
    }

    public function store(StoreMedicinesRequest $request)
    {
        $medicine = Medicine::create($request->all());
        

        return $medicine;
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
        return '';
    }
}
