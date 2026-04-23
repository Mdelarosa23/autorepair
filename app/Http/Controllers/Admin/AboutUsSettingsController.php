<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AboutUsSettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.about-us.edit', [
            'settings' => SiteSetting::aboutUsSettings(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'about_mission' => ['required', 'string', 'max:2000'],
            'about_vision' => ['required', 'string', 'max:2000'],
            'about_story' => ['required', 'string', 'max:4000'],
            'about_image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('about_image_file')) {
            $file = $request->file('about_image_file');
            $directory = $this->aboutUploadDirectory();

            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $existingPath = SiteSetting::getValue('about_image_path');
            if ($existingPath && str_starts_with($existingPath, 'assets/uploads/about-us/')) {
                $existingImagePath = $this->aboutUploadPath(basename($existingPath));
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['about_image_path'] = 'assets/uploads/about-us/' . $filename;
        }

        unset($data['about_image_file']);

        foreach ($data as $key => $value) {
            SiteSetting::setValue($key, trim((string) $value));
        }

        return redirect()->route('admin.about-us.edit')->with('status', 'About Us content updated successfully.');
    }

    protected function aboutUploadDirectory(): string
    {
        return app()->environment('production')
            ? base_path('../public_html/assets/uploads/about-us')
            : public_path('assets/uploads/about-us');
    }

    protected function aboutUploadPath(string $filename): string
    {
        return $this->aboutUploadDirectory() . DIRECTORY_SEPARATOR . $filename;
    }
}
