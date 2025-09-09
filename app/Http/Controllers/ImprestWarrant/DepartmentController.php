<?php

namespace App\Http\Controllers\ImprestWarrant;

use App\Actions\Store\StoreDepartmentAction;
use App\Actions\Update\UpdateDepartmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreDepartmentRequest;
use App\Http\Requests\Update\UpdateDepartmentRequest;
use App\Http\Resources\ImprestWarrant\DepartmentResource;
use App\Models\Department;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = DepartmentResource::collection(Department::all());

        return Inertia::render('imprest_warrant/departments', [
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request, StoreDepartmentAction $action)
    {
        $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department, UpdateDepartmentAction $action)
    {
        $action->execute($request->validated(), $department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
    }
}
