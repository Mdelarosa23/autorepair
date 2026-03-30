<x-admin.layouts.app :title="'Manage Works'">
    @php($editingItem = $editing)
    @php(
        $categoryLabels = collect($categories)->mapWithKeys(fn ($label, $value) => [$value => $label])->all()
    )
    @php(
        $layoutLabels = collect($layouts)->mapWithKeys(fn ($label, $value) => [$value => $label])->all()
    )
    @php(
        $resolveCategory = function (?string $value) use ($categoryLabels) {
            $normalized = strtolower(trim((string) $value));

            return match (true) {
                isset($categoryLabels[$normalized]) => $normalized,
                str_contains($normalized, 'web') => 'steering',
                str_contains($normalized, 'ui') => 'brakes',
                str_contains($normalized, 'ux') => 'suspension',
                str_contains($normalized, 'branding') => 'tyre',
                str_contains($normalized, 'tow') => 'tow',
                str_contains($normalized, 'wheel') || str_contains($normalized, 'tyre') => 'wheel',
                default => 'wheel',
            };
        }
    )

    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Works</h1>
                    <p class="page-subtitle">Manage featured work images with clear categories and cleaner gallery card sizes.</p>
                </div>
                <div class="user-badge">{{ $items->count() }} items</div>
            </div>

            @if (session('status'))
                <div class="notice" style="margin-top:0;margin-bottom:18px;">{{ session('status') }}</div>
            @endif

            <section class="panel">
                <div class="panel-body">
                    <div class="manager-toolbar">
                        <button type="button" class="primary-btn" data-modal-target="works-create-modal">Create Work Item</button>
                        <label class="manager-search">
                            <i class='bx bx-search'></i>
                            <input type="search" placeholder="Search works..." data-search-input="#works-table">
                        </label>
                    </div>

                    <div class="table-wrap">
                        <table class="manager-table" id="works-table" data-sort-table>
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th><button type="button" class="sort-btn" data-sort-key="title">Title <i class='bx bx-sort'></i></button></th>
                                    <th>Category</th>
                                    <th>Layout</th>
                                    <th><button type="button" class="sort-btn" data-sort-key="order" data-sort-type="number">Order <i class='bx bx-sort'></i></button></th>
                                    <th><button type="button" class="sort-btn" data-sort-key="status">Status <i class='bx bx-sort'></i></button></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php($path = $item->image_path)
                                    @php($imageUrl = str_starts_with($path, 'assets/img/') ? asset('mads-template/' . ltrim($path, '/')) : asset(ltrim($path, '/')))
                                    @php($categoryKey = $resolveCategory($item->filter_classes))
                                    <tr
                                        data-search-row="{{ strtolower(($item->title ?: '') . ' ' . $categoryLabels[$categoryKey]) }}"
                                        data-title="{{ strtolower($item->title ?: '') }}"
                                        data-order="{{ $item->sort_order }}"
                                        data-status="{{ $item->is_active ? 'active' : 'hidden' }}"
                                    >
                                        <td><img src="{{ $imageUrl }}" alt="{{ $item->title ?: 'Work item' }}" class="thumb"></td>
                                        <td>
                                            <strong>{{ $item->title ?: 'Untitled Work Item' }}</strong>
                                            <div class="table-muted">{{ $item->image_path }}</div>
                                        </td>
                                        <td><span class="status-badge active">{{ $categoryLabels[$categoryKey] }}</span></td>
                                        <td class="table-muted">{{ $layoutLabels[$item->column_class] ?? 'Custom Layout' }}</td>
                                        <td>{{ $item->sort_order }}</td>
                                        <td><span class="status-badge {{ $item->is_active ? 'active' : 'hidden' }}">{{ $item->is_active ? 'Active' : 'Hidden' }}</span></td>
                                        <td>
                                            <div class="actions">
                                                <a href="{{ route('admin.work-items.edit', $item) }}" class="secondary-btn">Edit</a>
                                                <form method="POST" action="{{ route('admin.work-items.destroy', $item) }}" onsubmit="return confirm('Delete this work item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="danger-btn">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal-backdrop" id="works-create-modal">
        <div class="modal-card">
            <div class="modal-header">
                <div>
                    <h2>Create Work Item</h2>
                    <p class="page-subtitle">Upload an image, choose a category, and pick a clear gallery layout.</p>
                </div>
                <button type="button" class="modal-close" data-modal-close>&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.work-items.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label>Title</label>
                            <input type="text" name="title" value="{{ old('title') }}">
                        </div>
                        <div class="field">
                            <label>Sort Order</label>
                            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $items->count() + 1) }}" required>
                        </div>
                        <div class="field">
                            <label>Image File</label>
                            <input type="file" name="image_file" accept="image/*" data-file-input="#work-create-file-name" required>
                            <div class="file-meta" id="work-create-file-name" data-empty-label="No file selected">No file selected</div>
                        </div>
                        <div class="field">
                            <label>Category</label>
                            <select name="category" required>
                                @foreach ($categories as $value => $label)
                                    <option value="{{ $value }}" @selected(old('category', 'wheel') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Gallery Layout</label>
                            <select name="column_class" required>
                                @foreach ($layouts as $value => $label)
                                    <option value="{{ $value }}" @selected(old('column_class', 'col-sm-6 col-lg-4') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Link URL</label>
                            <input type="text" name="link_url" value="{{ old('link_url', '#works') }}">
                            <small style="color:#6b7280;">Optional. The public gallery now opens images in a modal viewer.</small>
                        </div>
                    </div>

                    <label class="checkbox-row">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <span>Show this item</span>
                    </label>

                    <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:22px;">
                        <button type="button" class="ghost-btn" data-modal-close>Cancel</button>
                        <button type="submit" class="primary-btn">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($editingItem)
        @php($editingCategory = old('category', $resolveCategory($editingItem->filter_classes)))
        <div data-open-modal="works-edit-modal"></div>
        <div class="modal-backdrop" id="works-edit-modal">
            <div class="modal-card">
                <div class="modal-header">
                    <div>
                        <h2>Edit Work Item</h2>
                        <p class="page-subtitle">Update the image, category, and how this card appears in the gallery.</p>
                    </div>
                    <a href="{{ route('admin.work-items.index') }}" class="modal-close" style="display:inline-flex;align-items:center;justify-content:center;">&times;</a>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.work-items.update', $editingItem) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-grid">
                            <div class="field">
                                <label>Title</label>
                                <input type="text" name="title" value="{{ old('title', $editingItem->title) }}">
                            </div>
                            <div class="field">
                                <label>Sort Order</label>
                                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $editingItem->sort_order) }}" required>
                            </div>
                            <div class="field">
                                <label>Replace Image</label>
                                <input type="file" name="image_file" accept="image/*" data-file-input="#work-edit-file-name">
                                <div class="file-meta" id="work-edit-file-name" data-empty-label="Current: {{ $editingItem->image_path }}">Current: {{ $editingItem->image_path }}</div>
                            </div>
                            <div class="field">
                                <label>Category</label>
                                <select name="category" required>
                                    @foreach ($categories as $value => $label)
                                        <option value="{{ $value }}" @selected($editingCategory === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Gallery Layout</label>
                                <select name="column_class" required>
                                    @foreach ($layouts as $value => $label)
                                        <option value="{{ $value }}" @selected(old('column_class', $editingItem->column_class) === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>Link URL</label>
                                <input type="text" name="link_url" value="{{ old('link_url', $editingItem->link_url) }}">
                                <small style="color:#6b7280;">Optional. The public gallery now opens images in a modal viewer.</small>
                            </div>
                        </div>

                        <label class="checkbox-row">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $editingItem->is_active) ? 'checked' : '' }}>
                            <span>Show this item</span>
                        </label>

                        <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:22px;">
                            <a href="{{ route('admin.work-items.index') }}" class="ghost-btn">Cancel</a>
                            <button type="submit" class="primary-btn">Update Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-admin.layouts.app>
