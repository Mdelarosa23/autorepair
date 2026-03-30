<x-admin.layouts.app :title="'Edit Home Slide'">
<div class="admin-shell">@include('admin.partials.sidebar')<main class="main"><div class="topbar"><div><h1 class="page-title">Edit Home Slide</h1><p class="page-subtitle">Update homepage carousel content.</p></div><div class="user-badge">{{ $slide->title }}</div></div><section class="panel"><div class="panel-body" style="max-width:780px;"><form method="POST" action="{{ route('admin.home-slides.update', $slide) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="field"><label>Title</label><input type="text" name="title" value="{{ old('title', $slide->title) }}" required></div>
<div class="field"><label>Highlighted Word</label><input type="text" name="highlight_text" value="{{ old('highlight_text', $slide->highlight_text) }}"></div>
<div class="field"><label>Description</label><textarea name="description" rows="4" style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #d1d5db;font:inherit;">{{ old('description', $slide->description) }}</textarea></div>
<div class="field"><label>Primary Label</label><input type="text" name="primary_label" value="{{ old('primary_label', $slide->primary_label) }}"></div>
<div class="field"><label>Primary URL</label><input type="text" name="primary_url" value="{{ old('primary_url', $slide->primary_url) }}"></div>
<div class="field"><label>Secondary Label</label><input type="text" name="secondary_label" value="{{ old('secondary_label', $slide->secondary_label) }}"></div>
<div class="field"><label>Secondary URL</label><input type="text" name="secondary_url" value="{{ old('secondary_url', $slide->secondary_url) }}"></div>
<div class="field"><label>Background Image</label><input type="file" name="background_image_file" accept="image/*">@if($slide->background_image_path)<div style="margin-top:8px;color:#6b7280;">Current: {{ $slide->background_image_path }}</div>@endif</div>
<div class="field"><label>Sort Order</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order', $slide->sort_order) }}" required></div>
<label style="display:flex;gap:10px;margin-top:18px;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active) ? 'checked' : '' }}><span>Show this slide</span></label>
<div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:18px;"><button type="submit" class="primary-btn" style="width:auto;margin-top:0;">Save Changes</button><a href="{{ route('admin.home-slides.index') }}" style="display:inline-block;padding:13px 16px;border-radius:12px;background:#e5e7eb;color:#111827;font-weight:700;">Back</a></div></form></div></section></main></div>
</x-admin.layouts.app>
