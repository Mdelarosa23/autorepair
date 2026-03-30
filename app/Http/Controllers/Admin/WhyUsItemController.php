<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyUsItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhyUsItemController extends Controller
{
    public function index(): View
    {
        return view('admin.why-us.index', ['items' => WhyUsItem::query()->ordered()->get(), 'editing' => null]);
    }

    public function edit(WhyUsItem $whyU): View
    {
        return view('admin.why-us.index', ['items' => WhyUsItem::query()->ordered()->get(), 'editing' => $whyU]);
    }

    public function store(Request $request): RedirectResponse
    {
        WhyUsItem::query()->create($this->validatedData($request));
        return redirect()->route('admin.why-us.index')->with('status', 'Why Us item created successfully.');
    }

    public function update(Request $request, WhyUsItem $whyU): RedirectResponse
    {
        $whyU->update($this->validatedData($request));
        return redirect()->route('admin.why-us.index')->with('status', 'Why Us item updated successfully.');
    }

    public function destroy(WhyUsItem $whyU): RedirectResponse
    {
        $whyU->delete();
        return redirect()->route('admin.why-us.index')->with('status', 'Why Us item deleted successfully.');
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
