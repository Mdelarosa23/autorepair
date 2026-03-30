<x-admin.layouts.app :title="'Edit Service'">
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Edit Service</h1>
                    <p class="page-subtitle">Update the content and display settings for this service card.</p>
                </div>
                <div class="user-badge">
                    {{ $service->title }}
                </div>
            </div>

            <style>
                .checkbox-inline { display:flex; align-items:center; gap:10px; margin-top:18px; color:#4b5563; }
                .service-edit-actions { display:flex; gap:12px; flex-wrap:wrap; margin-top:18px; }
                .secondary-btn { display:inline-block; padding:13px 16px; border-radius:12px; background:#e5e7eb; color:#111827; font-weight:700; }
            </style>

            <section class="panel">
                <div class="panel-body" style="max-width:780px;">
                    <form method="POST" action="{{ route('admin.services.update', $service) }}">
                        @csrf
                        @method('PUT')

                        <div class="field">
                            <label for="title">Title</label>
                            <input id="title" type="text" name="title" value="{{ old('title', $service->title) }}" required>
                        </div>

                        <div class="field">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="4" style="width:100%; padding:12px 14px; border-radius:12px; border:1px solid #d1d5db; font:inherit;">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div class="field">
                            <label for="icon_class">Icon Class</label>
                            <input id="icon_class" type="text" name="icon_class" value="{{ old('icon_class', $service->icon_class) }}" required>
                        </div>

                        <div class="field">
                            <label for="image_path">Image Path</label>
                            <input id="image_path" type="text" name="image_path" value="{{ old('image_path', $service->image_path) }}">
                        </div>

                        <div class="field">
                            <label for="link_url">Link URL</label>
                            <input id="link_url" type="text" name="link_url" value="{{ old('link_url', $service->link_url) }}">
                        </div>

                        <div class="field">
                            <label for="sort_order">Sort Order</label>
                            <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" required>
                        </div>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <span>Show this service on the public website</span>
                        </label>

                        @foreach (['title','description','icon_class','image_path','link_url','sort_order','is_active'] as $field)
                            @error($field)
                                <small style="display:block; color:#b91c1c; margin-top:10px;">{{ $message }}</small>
                            @enderror
                        @endforeach

                        <div class="service-edit-actions">
                            <button type="submit" class="primary-btn" style="width:auto; margin-top:0;">Save Changes</button>
                            <a href="{{ route('admin.services.index') }}" class="secondary-btn">Back to Services</a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
