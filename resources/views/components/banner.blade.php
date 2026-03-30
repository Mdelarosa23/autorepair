@php($slides = \App\Models\HomeSlide::publicItems())

<!-- Banner -->
<div class="banner-slider owl-theme owl-carousel" id="home">
    @forelse ($slides as $slide)
        @php($backgroundPath = $slide->background_image_path ?? '')
        @php($backgroundUrl = $backgroundPath ? asset(ltrim($backgroundPath, '/')) : null)
        @php($highlightText = trim((string) ($slide->highlight_text ?? '')))
        @php($titleParts = $highlightText !== '' ? preg_split('/' . preg_quote($highlightText, '/') . '/', $slide->title, 2) : false)
        <div class="banner-area-three {{ $backgroundUrl ? '' : 'banner-img-one' }}" @if ($backgroundUrl) style="background-image: url('{{ $backgroundUrl }}');" @endif>
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="banner-text">
                                    <h1>
                                        @if ($titleParts !== false && count($titleParts) === 2)
                                            {{ $titleParts[0] }}<b style="color: var(--theme-accent);">{{ $highlightText }}</b>{{ $titleParts[1] }}
                                        @elseif ($highlightText !== '')
                                            <b style="color: var(--theme-accent);">{{ $highlightText }}</b> {{ $slide->title }}
                                        @else
                                            {{ $slide->title }}
                                        @endif
                                    </h1>
                                    <p>{{ $slide->description }}</p>
                                    <div class="cmn-btn">
                                        @if ($slide->primary_label && $slide->primary_url)
                                            <a class="banner-btn-left" href="{{ $slide->primary_url }}">
                                                <i class='bx bx-phone-call'></i>
                                                {{ $slide->primary_label }}
                                            </a>
                                        @endif
                                        @if ($slide->secondary_label && $slide->secondary_url)
                                            <a class="banner-btn-right" href="{{ $slide->secondary_url }}" target="_blank">
                                                <i class='bx bxs-truck'></i>
                                                {{ $slide->secondary_label }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="banner-area-three banner-img-one"><div class="d-table"><div class="d-table-cell"><div class="container"><div class="row justify-content-center"><div class="col-lg-12"><div class="banner-text"><h1>Mads Auto Repair</h1><p>Your homepage slider is empty.</p></div></div></div></div></div></div></div>
    @endforelse
</div>
<!-- End Banner -->
