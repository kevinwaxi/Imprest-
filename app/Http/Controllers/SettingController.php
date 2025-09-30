<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        $settings = Setting::all()->pluck('value', 'key');

        return Inertia::render('app/Settings', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'site'          => 'array',
            'communication' => 'array',
            'address'       => 'array',
            'authority'     => 'array',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
