<x-admin.layouts.app :title="'Admin Dashboard'">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['contentSections' => $contentSections])

        <main class="main">
            <div class="topbar">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Overview of your website admin space and quick access to content sections.</p>
                </div>
                <div class="user-badge">
                    Signed in as <strong>{{ auth()->user()->name }}</strong>
                </div>
            </div>

            <section class="stats-grid">
                @foreach ($stats as $stat)
                    <div class="stat-card">
                        <span class="stat-label">{{ $stat['label'] }}</span>
                        <div class="stat-value">{{ $stat['value'] }}</div>
                    </div>
                @endforeach
            </section>

            <section class="panel" style="margin-top: 24px;">
                <div class="panel-body">
                    <h2 style="margin-top: 0;">Content Areas</h2>
                    <p class="page-subtitle">Use the dropdown in the sidebar or jump straight into a section below.</p>

                    <div class="content-grid" style="margin-top: 18px;">
                        @foreach ($contentSections as $section)
                            <div class="content-card">
                                <h3>{{ $section['label'] }}</h3>
                                <p>Open the {{ strtolower($section['label']) }} section to review and update website content for this block.</p>
                                <a href="{{ route('admin.content', $section['slug']) }}">Manage {{ $section['label'] }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-admin.layouts.app>
