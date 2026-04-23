<x-admin.layouts.app :title="'Admin Content'">
    <div class="admin-shell">
        @include('admin.partials.sidebar', [
            'contentSections' => collect($sections)->map(fn ($section, $key) => ['label' => $section['title'], 'slug' => $key])->values()->all(),
        ])

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Content</h1>
                    <p class="page-subtitle">Select a website area and manage what should appear on the public site.</p>
                </div>
                <div class="user-badge">
                    Current section: <strong>{{ $selectedSection['title'] }}</strong>
                </div>
            </div>

            <section class="panel">
                <div class="panel-body">
                    <span class="stat-label">Selected Content Area</span>
                    <h2 style="margin-top: 10px;">{{ $selectedSection['title'] }}</h2>
                    <p class="page-subtitle">{{ $selectedSection['description'] }}</p>

                    @if (! empty($selectedSection['manage_url']))
                        <a href="{{ $selectedSection['manage_url'] }}" class="primary-btn" style="display:inline-block; width:auto; margin-top:18px; padding:13px 18px;">
                            {{ $selectedSection['manage_label'] ?? 'Manage Content' }}
                        </a>
                    @endif

                    <div class="content-grid" style="margin-top: 24px;">
                        @foreach ($sections as $key => $section)
                            @php
                                $sectionUrl = match ($key) {
                                    'services' => route('admin.services.index'),
                                    'about-us' => route('admin.about-us.edit'),
                                    'contact-cta' => route('admin.contact-settings.edit'),
                                    default => route('admin.content', $key),
                                };
                            @endphp
                            <div class="content-card">
                                <h3>{{ $section['title'] }}</h3>
                                <p>{{ $section['description'] }}</p>
                                @if ($key === 'contact-cta' && ! empty($section['summary']))
                                    <p class="table-muted" style="margin-top:12px;">
                                        Call: {{ $section['summary']['call_now_number'] }}<br>
                                        Towing: {{ $section['summary']['towing_service_number'] }}
                                    </p>
                                @endif
                                @if ($key === 'about-us' && ! empty($section['summary']))
                                    <p class="table-muted" style="margin-top:12px;">
                                        Mission: {{ \Illuminate\Support\Str::limit($section['summary']['about_mission'], 70) }}<br>
                                        Vision: {{ \Illuminate\Support\Str::limit($section['summary']['about_vision'], 70) }}
                                    </p>
                                @endif
                                <a href="{{ $sectionUrl }}">{{ $selectedKey === $key ? 'Currently Viewing' : 'Open Section' }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
