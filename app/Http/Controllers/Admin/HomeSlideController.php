<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HomeSlideController extends Controller
{
    public function index(): View
    {
        return view('admin.home-slides.index', ['slides' => HomeSlide::query()->ordered()->get(), 'editing' => null]);
    }

    public function edit(HomeSlide $homeSlide): View
    {
        return view('admin.home-slides.index', ['slides' => HomeSlide::query()->ordered()->get(), 'editing' => $homeSlide]);
    }

    public function store(Request $request): RedirectResponse
    {
        HomeSlide::query()->create($this->validatedData($request));
        return redirect()->route('admin.home-slides.index')->with('status', 'Slide created successfully.');
    }

    public function update(Request $request, HomeSlide $homeSlide): RedirectResponse
    {
        $homeSlide->update($this->validatedData($request, $homeSlide));
        return redirect()->route('admin.home-slides.index')->with('status', 'Slide updated successfully.');
    }

    public function destroy(HomeSlide $homeSlide): RedirectResponse
    {
        $homeSlide->delete();
        return redirect()->route('admin.home-slides.index')->with('status', 'Slide deleted successfully.');
    }

    protected function validatedData(Request $request, ?HomeSlide $homeSlide = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'highlight_text' => ['nullable', 'string', 'max:255'],
            'hook_message' => ['nullable', 'string', 'max:255'],
            'hook_highlight_text' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'primary_label' => ['nullable', 'string', 'max:255'],
            'primary_url' => ['nullable', 'string', 'max:255'],
            'secondary_label' => ['nullable', 'string', 'max:255'],
            'secondary_url' => ['nullable', 'string', 'max:255'],
            'background_image_file' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', Rule::in(['1'])],
        ]);

        if ($request->hasFile('background_image_file')) {
            $file = $request->file('background_image_file');
            $directory = $this->homeSlideUploadDirectory();
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $existingImagePath = $homeSlide?->background_image_path
                ? $this->homeSlideUploadPath(basename($homeSlide->background_image_path))
                : null;

            if ($existingImagePath && file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }

            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['background_image_path'] = 'assets/uploads/home-slides/' . $filename;
        }

        unset($data['background_image_file']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    protected function homeSlideUploadDirectory(): string
    {
        return app()->environment('production')
            ? base_path('../public_html/assets/uploads/home-slides')
            : public_path('assets/uploads/home-slides');
    }

    protected function homeSlideUploadPath(string $filename): string
    {
        return $this->homeSlideUploadDirectory() . DIRECTORY_SEPARATOR . $filename;
    }
}
