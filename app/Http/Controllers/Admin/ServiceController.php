<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => Service::query()->ordered()->get(),
            'editing' => null,
        ]);
    }

    public function edit(Service $service): View
    {
        return view('admin.services.index', [
            'services' => Service::query()->ordered()->get(),
            'editing' => $service,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Service::query()->create($this->validatedData($request));

        return redirect()->route('admin.services.index')->with('status', 'Service created successfully.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->validatedData($request, $service));

        return redirect()->route('admin.services.index')->with('status', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Service deleted successfully.');
    }

    protected function validatedData(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'icon_class' => ['required', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', Rule::in(['1'])],
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $directory = $this->serviceUploadDirectory();

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // DELETE OLD IMAGE
            $existingImagePath = $service?->image_path ? $this->serviceUploadPath(basename($service->image_path)) : null;
            if ($existingImagePath && file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }

            $filename = time() . '-' . Str::slug(
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            ) . '.' . $file->getClientOriginalExtension();

            $file->move($directory, $filename);

            $data['image_path'] = 'assets/uploads/services/' . $filename;
        }

        // if ($request->hasFile('image_file')) {
        //     $file = $request->file('image_file');
        //     $directory = public_path('assets/uploads/services');
        //     if (! is_dir($directory)) {
        //         mkdir($directory, 0777, true);
        //     }
        //     $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        //     $file->move($directory, $filename);
        //     $data['image_path'] = 'assets/uploads/services/' . $filename;
        // } elseif ($service) {
        //     $data['image_path'] = $service->image_path;
        // }

        unset($data['image_file']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    protected function serviceUploadDirectory(): string
    {
        return app()->environment('production')
            ? base_path('../public_html/assets/uploads/services')
            : public_path('assets/uploads/services');
    }

    protected function serviceUploadPath(string $filename): string
    {
        return $this->serviceUploadDirectory() . DIRECTORY_SEPARATOR . $filename;
    }
}
