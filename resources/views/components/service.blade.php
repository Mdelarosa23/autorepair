@php($services = \App\Models\Service::publicItems())

<!-- Service -->
<section class="pb-70" id="services">
    <div class="container">
        <div class="section-title">
            <span class="sub-title">service</span>
            <h2>Our Services</h2>
            <p>
                Professional auto repair and maintenance services you can trust, fast, reliable, and built for your safety.
            </p>
        </div>
        <div class="row justify-content-center">
            @forelse ($services as $service)
                @php($path = $service->image_path ?? '')
                @php($imageUrl = $path ? (str_starts_with($path, 'assets/img/') ? asset(ltrim($path, '/')) : asset(ltrim($path, '/'))) : asset('assets/img/home-one/service/1.jpg'))
                @php($isTowingService = str_contains(strtolower($service->title), 'tow'))
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ $service->link_url ?  : '#services' }}">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ $imageUrl }}" alt="{{ $service->title }}">
                            </div>
                            <div class="service-content">
                                <i class='{{ $service->icon_class }}'></i>
                                <i class='{{ $service->icon_class }} service-icon'></i>
                                <h3>{{ $service->title }}</h3>
                                <p>{{ $service->description }}</p>
                                @if ($isTowingService)
                                    <a href="tel:+{{ $siteContact['towing_service_number'] }}" target="_blank" style="margin-top: 10px; font-weight: 700; color: var(--theme-accent);">
                                        Call {{ $siteContact['towing_service_number'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No services available right now.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- End Service -->
