<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WorkItemController extends Controller
{
    private const CATEGORY_OPTIONS = [
        'wheel' => 'Wheel',
        'steering' => 'Steering',
        'brakes' => 'Brakes',
        'suspension' => 'Suspension',
        'tyre' => 'Tyre',
        'tow' => 'Tow',
    ];

    private const LAYOUT_OPTIONS = [
        'col-sm-6 col-lg-3' => 'Small',
        'col-sm-6 col-lg-4' => 'Medium',
        'col-sm-6 col-lg-6' => 'Large',
    ];

    public function index(): View
    {
        return view('admin.work-items.index', [
            'items' => WorkItem::query()->ordered()->get(),
            'editing' => null,
            'categories' => self::CATEGORY_OPTIONS,
            'layouts' => self::LAYOUT_OPTIONS,
        ]);
    }

    public function edit(WorkItem $workItem): View
    {
        return view('admin.work-items.index', [
            'items' => WorkItem::query()->ordered()->get(),
            'editing' => $workItem,
            'categories' => self::CATEGORY_OPTIONS,
            'layouts' => self::LAYOUT_OPTIONS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        WorkItem::query()->create($this->validatedData($request));
        return redirect()->route('admin.work-items.index')->with('status', 'Work item created successfully.');
    }

    public function update(Request $request, WorkItem $workItem): RedirectResponse
    {
        $workItem->update($this->validatedData($request, $workItem));
        return redirect()->route('admin.work-items.index')->with('status', 'Work item updated successfully.');
    }

    public function destroy(WorkItem $workItem): RedirectResponse
    {
        $workItem->delete();
        return redirect()->route('admin.work-items.index')->with('status', 'Work item deleted successfully.');
    }

    protected function validatedData(Request $request, ?WorkItem $item = null): array
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image_file' => [$item ? 'nullable' : 'required', 'image', 'max:4096'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(self::CATEGORY_OPTIONS))],
            'column_class' => ['required', 'string', 'in:' . implode(',', array_keys(self::LAYOUT_OPTIONS))],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $directory = public_path('assets/uploads/works');
            if (! is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['image_path'] = 'assets/uploads/works/' . $filename;
        } elseif ($item) {
            $data['image_path'] = $item->image_path;
        }

        unset($data['image_file']);
        $data['filter_classes'] = $data['category'];
        unset($data['category']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
