<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqItemController extends Controller
{
    public function index(): View
    {
        return view('admin.faq-items.index', ['items' => FaqItem::query()->ordered()->get(), 'editing' => null]);
    }

    public function edit(FaqItem $faqItem): View
    {
        return view('admin.faq-items.index', ['items' => FaqItem::query()->ordered()->get(), 'editing' => $faqItem]);
    }

    public function store(Request $request): RedirectResponse
    {
        FaqItem::query()->create($this->validatedData($request));
        return redirect()->route('admin.faq-items.index')->with('status', 'FAQ item created successfully.');
    }

    public function update(Request $request, FaqItem $faqItem): RedirectResponse
    {
        $faqItem->update($this->validatedData($request));
        return redirect()->route('admin.faq-items.index')->with('status', 'FAQ item updated successfully.');
    }

    public function destroy(FaqItem $faqItem): RedirectResponse
    {
        $faqItem->delete();
        return redirect()->route('admin.faq-items.index')->with('status', 'FAQ item deleted successfully.');
    }

    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
