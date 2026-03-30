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
                                $sectionUrl = $key === 'services' ? route('admin.services.index') : route('admin.content', $key);
                            @endphp
                            <div class="content-card">
                                <h3>{{ $section['title'] }}</h3>
                                <p>{{ $section['description'] }}</p>
                                <a href="{{ $sectionUrl }}">{{ $selectedKey === $key ? 'Currently Viewing' : 'Open Section' }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
