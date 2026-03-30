<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcessStepController extends Controller
{
    public function index(): View
    {
        return view('admin.process-steps.index', ['steps' => ProcessStep::query()->ordered()->get(), 'editing' => null]);
    }

    public function edit(ProcessStep $processStep): View
    {
        return view('admin.process-steps.index', ['steps' => ProcessStep::query()->ordered()->get(), 'editing' => $processStep]);
    }

    public function store(Request $request): RedirectResponse
    {
        ProcessStep::query()->create($this->validatedData($request));
        return redirect()->route('admin.process-steps.index')->with('status', 'Process step created successfully.');
    }

    public function update(Request $request, ProcessStep $processStep): RedirectResponse
    {
        $processStep->update($this->validatedData($request));
        return redirect()->route('admin.process-steps.index')->with('status', 'Process step updated successfully.');
    }

    public function destroy(ProcessStep $processStep): RedirectResponse
    {
        $processStep->delete();
        return redirect()->route('admin.process-steps.index')->with('status', 'Process step deleted successfully.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'icon_class' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
