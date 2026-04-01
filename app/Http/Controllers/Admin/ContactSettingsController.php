<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.contact-settings.edit', [
            'settings' => SiteSetting::contactSettings(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'call_now_number' => ['required', 'string', 'max:255'],
            'request_tow_label' => ['required', 'string', 'max:255'],
            'request_tow_url' => ['required', 'url', 'max:255'],
            'towing_service_number' => ['required', 'string', 'max:255'],
            'working_hours' => ['required', 'string', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::setValue($key, trim($value));
        }

        return redirect()->route('admin.contact-settings.edit')->with('status', 'Contact and CTA settings updated successfully.');
    }
}
