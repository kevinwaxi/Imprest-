<?php

namespace App\Http\Controllers\ImprestWarrant;

use App\Actions\Store\StoreWarrantAction;
use App\Actions\Update\UpdateWarrantAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreWarrantRequest;
use App\Http\Requests\Update\UpdateWarrantRequest;
use App\Http\Resources\ImprestWarrant\WarrantResource;
use App\Models\Warrant;
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;

class WarrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warrants      = WarrantResource::collection(Warrant::with(['staff', 'account', 'project', 'preparedBy'])->get());

        return Inertia::render('imprest_warrant/warrants', [
            'warrants'      => $warrants,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarrantRequest $request, StoreWarrantAction $action)
    {
        $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Warrant $warrant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarrantRequest $request, Warrant $warrant, UpdateWarrantAction $action)
    {
        $action->execute($request->validated(), $warrant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warrant $warrant)
    {
        $warrant->delete();
    }

    public function download(Warrant $warrant)
    {
        // Prepare data for the Blade template
        $payload = [
            'warrant' => $warrant->load(['staff', 'project', 'account']),
        ];

        // Render Blade into HTML
        $template = view('warrant', $payload)->render();

        // Generate PDF with Browsershot
        $pdfPath = storage_path("app/reports/warrant-{$warrant->id}.pdf");

        Browsershot::html($template)
            ->showBackground()
            ->setChromePath('/usr/bin/chromium')
            ->margins(4, 0, 4, 0)
            ->format('A4')
            ->save($pdfPath);

        // Return as download
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
