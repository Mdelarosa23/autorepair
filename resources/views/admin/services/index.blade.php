<x-admin.layouts.app :title="'Manage Services'">
    @php($editingService = $editing)
    <div class="admin-shell">
        @include('admin.partials.sidebar')
        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Services</h1>
                    <p class="page-subtitle">Manage service cards with search, sorting, modal editing, uploads, and icon selection.</p>
                </div>
                <div class="user-badge">{{ $services->count() }} service {{ $services->count() === 1 ? 'item' : 'items' }}</div>
            </div>

            @if (session('status'))
                <div class="notice" style="margin-top:0; margin-bottom:18px;">{{ session('status') }}</div>
            @endif

            <section class="panel">
                <div class="panel-body">
                    <div class="manager-toolbar">
                        <button type="button" class="primary-btn" data-modal-target="service-create-modal">Create Service</button>
                        <label class="manager-search">
                            <i class='bx bx-search'></i>
                            <input type="search" placeholder="Search services..." data-search-input="#services-table">
                        </label>
                    </div>

                    <div class="table-wrap">
                        <table class="manager-table" id="services-table" data-sort-table>
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th><button type="button" class="sort-btn" data-sort-key="title" data-sort-type="text">Title <i class='bx bx-sort'></i></button></th>
                                    <th><button type="button" class="sort-btn" data-sort-key="description" data-sort-type="text">Description <i class='bx bx-sort'></i></button></th>
                                    <th><button type="button" class="sort-btn" data-sort-key="order" data-sort-type="number">Order <i class='bx bx-sort'></i></button></th>
                                    <th><button type="button" class="sort-btn" data-sort-key="status" data-sort-type="text">Status <i class='bx bx-sort'></i></button></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    @php($path = $service->image_path ?? '')
                                    @php($imageUrl = $path ? (str_starts_with($path, 'assets/img/') ? asset(ltrim($path, '/')) : asset(ltrim($path, '/'))) : null)
                                    <tr data-search-row="{{ strtolower($service->title . ' ' . $service->description . ' ' . $service->icon_class) }}" data-title="{{ strtolower($service->title) }}" data-description="{{ strtolower($service->description) }}" data-order="{{ $service->sort_order }}" data-status="{{ $service->is_active ? 'active' : 'hidden' }}">
                                        <td>
                                            @if ($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="{{ $service->title }}" class="thumb">
                                            @else
                                                <span class="icon-chip-preview"><i class="{{ $service->icon_class }}"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $service->title }}</strong><br>
                                            <span class="table-muted"><i class="{{ $service->icon_class }}"></i> {{ $service->icon_class }}</span>
                                        </td>
                                        <td class="table-muted">{{ $service->description }}</td>
                                        <td>{{ $service->sort_order }}</td>
                                        <td><span class="status-badge {{ $service->is_active ? 'active' : 'hidden' }}">{{ $service->is_active ? 'Active' : 'Hidden' }}</span></td>
                                        <td>
                                            <div class="actions">
                                                <a href="{{ route('admin.services.edit', $service) }}" class="secondary-btn">Edit</a>
                                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="danger-btn">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="empty-state">No services yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal-backdrop" id="service-create-modal">
        <div class="modal-card">
            <div class="modal-header"><div><h2>Create Service</h2><p class="page-subtitle">Add a new public service card.</p></div><button type="button" class="modal-close" data-modal-close>&times;</button></div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="field"><label>Title</label><input type="text" name="title" value="{{ old('title') }}" required></div>
                        <div class="field"><label>Sort Order</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order', $services->count() + 1) }}" required></div>
                        <div class="field full"><label>Description</label><textarea name="description">{{ old('description') }}</textarea></div>
                        <div class="field full"><label>Icon</label>@include('admin.partials.icon-picker', ['name' => 'icon_class', 'selected' => old('icon_class', 'bx bxs-wrench')])</div>
                        <div class="field"><label>Image File</label><input type="file" name="image_file" accept="image/*" data-file-input="#service-create-file-name"><div class="file-meta" id="service-create-file-name" data-empty-label="No file selected">No file selected</div></div>
                        {{-- <div class="field"><label>Link URL</label><input type="text" name="link_url" value="{{ old('link_url', '#services') }}"></div> --}}
                    </div>
                    <label class="checkbox-row"><input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}><span>Show this service on the public site</span></label>
                    <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:22px;"><button type="button" class="ghost-btn" data-modal-close>Cancel</button><button type="submit" class="primary-btn">Save Service</button></div>
                </form>
            </div>
        </div>
    </div>

    @if ($editingService)
        <div data-open-modal="service-edit-modal"></div>
        <div class="modal-backdrop" id="service-edit-modal">
            <div class="modal-card">
                <div class="modal-header"><div><h2>Edit Service</h2><p class="page-subtitle">Update {{ $editingService->title }}.</p></div><a href="{{ route('admin.services.index') }}" class="modal-close" style="display:inline-flex;align-items:center;justify-content:center;">&times;</a></div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.services.update', $editingService) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-grid">
                            <div class="field"><label>Title</label><input type="text" name="title" value="{{ old('title', $editingService->title) }}" required></div>
                            <div class="field"><label>Sort Order</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order', $editingService->sort_order) }}" required></div>
                            <div class="field full"><label>Description</label><textarea name="description">{{ old('description', $editingService->description) }}</textarea></div>
                            <div class="field full"><label>Icon</label>@include('admin.partials.icon-picker', ['name' => 'icon_class', 'selected' => old('icon_class', $editingService->icon_class)])</div>
                            <div class="field"><label>Replace Image</label><input type="file" name="image_file" accept="image/*" data-file-input="#service-edit-file-name"><div class="file-meta" id="service-edit-file-name" data-empty-label="Current: {{ $editingService->image_path ?: 'No image selected' }}">Current: {{ $editingService->image_path ?: 'No image selected' }}</div></div>
                            {{-- <div class="field"><label>Link URL</label><input type="text" name="link_url" value="{{ old('link_url', $editingService->link_url) }}"></div> --}}
                        </div>
                        <label class="checkbox-row"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $editingService->is_active) ? 'checked' : '' }}><span>Show this service on the public site</span></label>
                        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:22px;"><a href="{{ route('admin.services.index') }}" class="ghost-btn">Cancel</a><button type="submit" class="primary-btn">Update Service</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-admin.layouts.app>
