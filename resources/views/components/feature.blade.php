@php($items = \App\Models\WhyUsItem::publicItems()->values())

<!-- Feature -->
<div class="feature-area" id="why-us">
    <div class="feature-shape">
        <img src="assets/img/home-one/feature-shape.png" alt="Feature">
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-3 p-0">
                <div class="feature-img">
                    <img src="assets/img/home-one/feature-bg.jpg" alt="Feature">
                </div>
            </div>
            <div class="col-lg-9 p-0">
                <div class="feature-content">
                    <h2>Why Us</h2>
                    {{-- <div class="feature-warranty" style="display:inline-flex;align-items:center;gap:14px;margin:0 0 28px;padding:14px 18px;border-radius:16px;background:rgba(253, 184, 25, 0.12);border:1px solid rgba(253, 184, 25, 0.3);">
                        <i class='bx bxs-badge-check' style="font-size:32px;color:var(--theme-accent);"></i>
                        <div>
                            <strong style="display:block;color:#111827;">Warranty Coverage</strong>
                            <span></span>
                        </div>
                    </div> --}}
                    <div class="feature-columns">
                        @foreach ($items->chunk(ceil(max($items->count(), 1) / 2)) as $chunk)
                            <ul class="feature-list">
                                @foreach ($chunk as $item)
                                    <li>
                                        <i class='{{ $item->icon_class }}'></i>
                                        <h3>{{ $item->title }}</h3>
                                        <p>{{ $item->description }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Feature -->
