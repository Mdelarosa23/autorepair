<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function edit()
    {
        return view('admin.theme.edit', [
            'settings' => SiteSetting::themeSettings(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'light_accent' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'light_background' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'light_text' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'dark_accent' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'dark_background' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'dark_text' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::setValue($key, strtoupper($value));
        }

        return redirect()->route('admin.theme.edit')->with('status', 'Theme colors updated successfully.');
    }
}
