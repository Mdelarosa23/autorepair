<x-admin.layouts.app :title="'About Us'">
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">About Us</h1>
                    <p class="page-subtitle">Manage the mission, vision, story, and image shown before the FAQ section.</p>
                </div>
            </div>

            <section class="panel">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="notice" style="margin-top:0; margin-bottom:18px;">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.about-us.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="content-grid">
                            <div class="content-card">
                                <h3>Core Message</h3>
                                <div class="field">
                                    <label for="about_story">Story</label>
                                    <textarea id="about_story" name="about_story" rows="6" required>{{ old('about_story', $settings['about_story']) }}</textarea>
                                </div>
                                <div class="field">
                                    <label for="about_mission">Mission</label>
                                    <textarea id="about_mission" name="about_mission" rows="4" required>{{ old('about_mission', $settings['about_mission']) }}</textarea>
                                </div>
                                <div class="field">
                                    <label for="about_vision">Vision</label>
                                    <textarea id="about_vision" name="about_vision" rows="4" required>{{ old('about_vision', $settings['about_vision']) }}</textarea>
                                </div>
                                
                            </div>

                            <div class="content-card">
                                <h3>Section Image</h3>
                                <div class="field">
                                    <label for="about_image_file">Upload Image</label>
                                    <input id="about_image_file" type="file" name="about_image_file" accept="image/*">
                                </div>
                                <p class="table-muted" style="margin-top:10px;">Recommended: landscape image, at least 900x700.</p>
                                @if (! empty($settings['about_image_path']))
                                    <div style="margin-top:14px;">
                                        <img src="{{ asset(ltrim($settings['about_image_path'], '/')) }}" alt="About Us Image Preview" style="width:100%;border-radius:14px;border:1px solid #e5e7eb;">
                                    </div>
                                    <p class="table-muted" style="margin-top:8px;">Current: {{ $settings['about_image_path'] }}</p>
                                @endif
                            </div>
                        </div>

                        @foreach (['about_mission', 'about_vision', 'about_story', 'about_image_file'] as $field)
                            @error($field)
                                <small style="display:block; color:#b91c1c; margin-top:10px;">{{ $message }}</small>
                            @enderror
                        @endforeach

                        <button type="submit" class="primary-btn" style="max-width:260px;">Save About Us</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
