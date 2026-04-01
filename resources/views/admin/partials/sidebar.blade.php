@php
    $contentOpen = request()->routeIs('admin.content')
        || request()->routeIs('admin.services.*')
        || request()->routeIs('admin.home-slides.*')
        || request()->routeIs('admin.process-steps.*')
        || request()->routeIs('admin.why-us.*')
        || request()->routeIs('admin.work-items.*')
        || request()->routeIs('admin.faq-items.*')
        || request()->routeIs('admin.contact-settings.*');
    $currentSection = request()->route('section');
    $contentSections = $contentSections ?? [
        ['label' => 'Home Slider', 'slug' => 'home-slider'],
        ['label' => 'Process', 'slug' => 'process'],
        ['label' => 'Services', 'slug' => 'services'],
        ['label' => 'Why Us', 'slug' => 'why-us'],
        ['label' => 'Works', 'slug' => 'works'],
        ['label' => 'FAQ', 'slug' => 'faq'],
        ['label' => 'Contact & CTA', 'slug' => 'contact-cta'],
    ];

    $routeMap = [
        'home-slider' => 'admin.home-slides.index',
        'process' => 'admin.process-steps.index',
        'services' => 'admin.services.index',
        'why-us' => 'admin.why-us.index',
        'works' => 'admin.work-items.index',
        'faq' => 'admin.faq-items.index',
        'contact-cta' => 'admin.contact-settings.edit',
    ];
@endphp

<aside class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <strong>Mads Admin</strong>
        <small>Website Management</small>
    </a>

    <nav class="nav-section">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span>Dashboard</span>
        </a>

        <details class="nav-dropdown" {{ $contentOpen ? 'open' : '' }}>
            <summary class="nav-summary">
                <span>Content</span>
                <span>{{ $contentOpen ? '-' : '+' }}</span>
            </summary>
            <div class="nav-sublinks">
                @foreach ($contentSections as $section)
                    @php
                        $routeName = $routeMap[$section['slug']] ?? 'admin.content';
                        $isActive = request()->routeIs(str_replace('.index', '.*', $routeName)) || $currentSection === $section['slug'];
                    @endphp
                    <a href="{{ $routeName === 'admin.content' ? route($routeName, $section['slug']) : route($routeName) }}" class="nav-sublink {{ $isActive ? 'active' : '' }}">
                        {{ $section['label'] }}
                    </a>
                @endforeach
            </div>
        </details>

        <a href="{{ route('admin.theme.edit') }}" class="nav-link {{ request()->routeIs('admin.theme.*') ? 'active' : '' }}">
            <span>Theme Colors</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</aside>
