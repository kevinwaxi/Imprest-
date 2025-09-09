<?php

namespace App\Http\Controllers\ImprestWarrant;

use App\Actions\Store\StoreStaffAction;
use App\Actions\Update\UpdateStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreStaffRequest;
use App\Http\Requests\Update\UpdateStaffRequest;
use App\Http\Resources\ImprestWarrant\StaffResource;
use App\Models\Staff;
use Inertia\Inertia;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = StaffResource::collection(Staff::all());
        return Inertia::render('imprest_warrant/staff', [
            'staff' => $staff,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request, StoreStaffAction $action)
    {
        $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff, UpdateStaffAction $action)
    {
        $action->execute($request->validated(), $staff);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
    }
}
