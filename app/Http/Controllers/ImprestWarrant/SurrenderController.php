<?php

namespace App\Http\Controllers\ImprestWarrant;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImprestWarrant\SurrenderResource;
use App\Models\Surrender;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SurrenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surrenders = SurrenderResource::collection(Surrender::with(['warrant.staff', 'warrant.project', 'warrant.preparedBy', 'warrant.department'])->get());
        return Inertia::render('imprest_warrant/surrenders', [
            'surrenders' => $surrenders,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Surrender $surrender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surrender $surrender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surrender $surrender)
    {
        //
    }
}
