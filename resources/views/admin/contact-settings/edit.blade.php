<x-admin.layouts.app :title="'Contact & CTA'">
    <div class="admin-shell">
        @include('admin.partials.sidebar')

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Contact & CTA</h1>
                    <p class="page-subtitle">Update the shared phone numbers, tow request link, and working hours used across the public site.</p>
                </div>
                <div class="user-badge">
                    Shared website settings
                </div>
            </div>

            <section class="panel">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="notice" style="margin-top:0; margin-bottom:18px;">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.contact-settings.update') }}">
                        @csrf

                        <div class="content-grid">
                            <div class="content-card">
                                <h3>Main Contact</h3>
                                <div class="field">
                                    <label for="call_now_number">Call Now Number</label>
                                    <input id="call_now_number" type="text" name="call_now_number" value="{{ old('call_now_number', $settings['call_now_number']) }}" required>
                                </div>
                                <div class="field">
                                    <label for="request_tow_label">Tow Button Label</label>
                                    <input id="request_tow_label" type="text" name="request_tow_label" value="{{ old('request_tow_label', $settings['request_tow_label']) }}" required>
                                </div>
                                <div class="field">
                                    <label for="request_tow_url">Tow Request Link</label>
                                    <input id="request_tow_url" type="url" name="request_tow_url" value="{{ old('request_tow_url', $settings['request_tow_url']) }}" required>
                                </div>
                            </div>

                            <div class="content-card">
                                <h3>Towing & Hours</h3>
                                <div class="field">
                                    <label for="towing_service_number">Towing Service Number</label>
                                    <input id="towing_service_number" type="text" name="towing_service_number" value="{{ old('towing_service_number', $settings['towing_service_number']) }}" required>
                                </div>
                                <div class="field">
                                    <label for="working_hours">Working Hours</label>
                                    <input id="working_hours" type="text" name="working_hours" value="{{ old('working_hours', $settings['working_hours']) }}" required>
                                </div>
                                <p class="table-muted" style="margin-top:12px;">Use a simple text string, for example: Mon-Fri: 8:30am-6:00pm.</p>
                            </div>
                        </div>

                        @foreach (['call_now_number', 'request_tow_label', 'request_tow_url', 'towing_service_number', 'working_hours'] as $field)
                            @error($field)
                                <small style="display:block; color:#b91c1c; margin-top:10px;">{{ $message }}</small>
                            @enderror
                        @endforeach

                        <button type="submit" class="primary-btn" style="max-width:260px;">Save Contact Settings</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
