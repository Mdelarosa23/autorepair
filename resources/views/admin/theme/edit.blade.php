<x-admin.layouts.app :title="'Theme Colors'">
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Theme Colors</h1>
                    <p class="page-subtitle">Manage the colors used for light mode and dark mode on the public website.</p>
                </div>
                <div class="user-badge">
                    Theme settings
                </div>
            </div>

            <section class="panel">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="notice" style="margin-top:0; margin-bottom:18px;">{{ session('status') }}</div>
                    @endif

                    <style>
                        .theme-preview-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; margin-bottom:18px; }
                        .theme-preview-card { border:1px solid #e5e7eb; border-radius:18px; overflow:hidden; background:#fff; }
                        .theme-preview-head { padding:16px 18px; border-bottom:1px solid #e5e7eb; }
                        .theme-preview-head h3 { margin:0; }
                        .theme-preview-body { padding:18px; }
                        .theme-preview-chip { display:inline-flex; align-items:center; gap:10px; margin:0 12px 12px 0; font-size:.95rem; color:#6b7280; }
                        .theme-preview-swatch { width:18px; height:18px; border-radius:999px; border:1px solid rgba(17,24,39,.12); box-shadow:inset 0 0 0 1px rgba(255,255,255,.25); }
                        .theme-preview-surface { border-radius:16px; padding:18px; }
                        .theme-preview-surface h4 { margin:0 0 8px; }
                        .theme-preview-surface p { margin:0 0 14px; line-height:1.6; }
                        .theme-preview-btn { display:inline-block; padding:10px 14px; border-radius:999px; font-weight:700; }
                        .field.color-field input[type=color] { height:52px; padding:6px; cursor:pointer; }
                        .color-meta { display:flex; align-items:center; gap:10px; margin-top:8px; color:#6b7280; font-size:.92rem; }
                        .color-code { display:inline-flex; align-items:center; min-height:36px; padding:0 12px; border-radius:10px; background:#f9fafb; border:1px solid #e5e7eb; font-family:Consolas,"Courier New",monospace; color:#111827; }
                        @media (max-width: 991px) { .theme-preview-grid { grid-template-columns:1fr; } }
                    </style>

                    <div class="theme-preview-grid">
                        <article class="theme-preview-card">
                            <div class="theme-preview-head">
                                <h3>Light Mode Preview</h3>
                            </div>
                            <div class="theme-preview-body">
                                <div class="theme-preview-chip"><span class="theme-preview-swatch" style="background: {{ $settings['light_accent'] }}"></span> Accent {{ $settings['light_accent'] }}</div>
                                <div class="theme-preview-chip"><span class="theme-preview-swatch" style="background: {{ $settings['light_background'] }}"></span> Background {{ $settings['light_background'] }}</div>
                                <div class="theme-preview-chip"><span class="theme-preview-swatch" style="background: {{ $settings['light_text'] }}"></span> Text {{ $settings['light_text'] }}</div>
                                <div class="theme-preview-surface" style="background: {{ $settings['light_background'] }}; color: {{ $settings['light_text'] }}; border:1px solid rgba(17,24,39,.08);">
                                    <h4 style="color: {{ $settings['light_text'] }};">Mads Auto Repair</h4>
                                    <p>Quick preview of the currently saved light mode palette.</p>
                                    <span class="theme-preview-btn" style="background: {{ $settings['light_accent'] }}; color: {{ $settings['light_background'] }};">Primary Action</span>
                                </div>
                            </div>
                        </article>

                        <article class="theme-preview-card" style="background:#111827; border-color:#1f2937;">
                            <div class="theme-preview-head" style="border-color:#1f2937;">
                                <h3 style="color:#fff;">Dark Mode Preview</h3>
                            </div>
                            <div class="theme-preview-body">
                                <div class="theme-preview-chip" style="color:#cbd5e1;"><span class="theme-preview-swatch" style="background: {{ $settings['dark_accent'] }}"></span> Accent {{ $settings['dark_accent'] }}</div>
                                <div class="theme-preview-chip" style="color:#cbd5e1;"><span class="theme-preview-swatch" style="background: {{ $settings['dark_background'] }}"></span> Background {{ $settings['dark_background'] }}</div>
                                <div class="theme-preview-chip" style="color:#cbd5e1;"><span class="theme-preview-swatch" style="background: {{ $settings['dark_text'] }}"></span> Text {{ $settings['dark_text'] }}</div>
                                <div class="theme-preview-surface" style="background: {{ $settings['dark_background'] }}; color: {{ $settings['dark_text'] }}; border:1px solid rgba(255,255,255,.08);">
                                    <h4 style="color: {{ $settings['dark_text'] }};">Mads Auto Repair</h4>
                                    <p>Quick preview of the currently saved dark mode palette.</p>
                                    <span class="theme-preview-btn" style="background: {{ $settings['dark_accent'] }}; color: {{ $settings['dark_background'] }};">Primary Action</span>
                                </div>
                            </div>
                        </article>
                    </div>

                    <form method="POST" action="{{ route('admin.theme.update') }}">
                        @csrf

                        <div class="content-grid">
                            <div class="content-card">
                                <h3>Light Mode</h3>
                                <div class="field color-field">
                                    <label for="light_accent">Accent Color</label>
                                    <input id="light_accent" type="color" name="light_accent" value="{{ old('light_accent', $settings['light_accent']) }}">
                                    <div class="color-meta">
                                        <span>Current value</span>
                                        <span class="color-code" data-color-output="light_accent">{{ old('light_accent', $settings['light_accent']) }}</span>
                                    </div>
                                </div>
                                <div class="field color-field">
                                    <label for="light_background">Background Color</label>
                                    <input id="light_background" type="color" name="light_background" value="{{ old('light_background', $settings['light_background']) }}">
                                    <div class="color-meta">
                                        <span>Current value</span>
                                        <span class="color-code" data-color-output="light_background">{{ old('light_background', $settings['light_background']) }}</span>
                                    </div>
                                </div>
                                <div class="field color-field">
                                    <label for="light_text">Text Color</label>
                                    <input id="light_text" type="color" name="light_text" value="{{ old('light_text', $settings['light_text']) }}">
                                    <div class="color-meta">
                                        <span>Current value</span>
                                        <span class="color-code" data-color-output="light_text">{{ old('light_text', $settings['light_text']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="content-card">
                                <h3>Dark Mode</h3>
                                <div class="field color-field">
                                    <label for="dark_accent">Accent Color</label>
                                    <input id="dark_accent" type="color" name="dark_accent" value="{{ old('dark_accent', $settings['dark_accent']) }}">
                                    <div class="color-meta">
                                        <span>Current value</span>
                                        <span class="color-code" data-color-output="dark_accent">{{ old('dark_accent', $settings['dark_accent']) }}</span>
                                    </div>
                                </div>
                                <div class="field color-field">
                                    <label for="dark_background">Background Color</label>
                                    <input id="dark_background" type="color" name="dark_background" value="{{ old('dark_background', $settings['dark_background']) }}">
                                    <div class="color-meta">
                                        <span>Current value</span>
                                        <span class="color-code" data-color-output="dark_background">{{ old('dark_background', $settings['dark_background']) }}</span>
                                    </div>
                                </div>
                                <div class="field color-field">
                                    <label for="dark_text">Text Color</label>
                                    <input id="dark_text" type="color" name="dark_text" value="{{ old('dark_text', $settings['dark_text']) }}">
                                    <div class="color-meta">
                                        <span>Current value</span>
                                        <span class="color-code" data-color-output="dark_text">{{ old('dark_text', $settings['dark_text']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach (['light_accent','light_background','light_text','dark_accent','dark_background','dark_text'] as $field)
                            @error($field)
                                <small style="display:block; color:#b91c1c; margin-top:10px;">{{ $message }}</small>
                            @enderror
                        @endforeach

                        <button type="submit" class="primary-btn" style="max-width:260px;">Save Theme Colors</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.querySelectorAll('input[type="color"]').forEach(function (input) {
            var output = document.querySelector('[data-color-output="' + input.name + '"]');

            if (! output) {
                return;
            }

            var sync = function () {
                output.textContent = input.value.toUpperCase();
            };

            sync();
            input.addEventListener('input', sync);
            input.addEventListener('change', sync);
        });
    </script>
</x-admin.layouts.app>
