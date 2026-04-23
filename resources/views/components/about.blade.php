@php($about = $siteAboutUs ?? \App\Models\SiteSetting::aboutUsSettings())
@php($aboutImagePath = trim((string) ($about['about_image_path'] ?? '')))
@php($aboutImageUrl = $aboutImagePath !== '' ? asset(ltrim($aboutImagePath, '/')) : asset('assets/img/whyus.png'))

<!-- About -->
<section class="about-area  pb-70" id="about-us">
    <div class="container">
        <div class="section-title">
            <span class="sub-title">About Us</span>
            <h2>Built On Trust, Driven By Craft</h2>
        </div>

        <div class="row align-items-stretch">
            <div class="col-lg-5">
                <div class="about-media">
                    <img src="{{ $aboutImageUrl }}" alt="About {{ $siteBusiness['name'] ?? 'Our Shop' }}">
                </div>
            </div>

            <div class="col-lg-7">
                <div class="about-copy">
                    <div class="about-card">
                        <h3>About Mads Auto Repair</h3>
                        <p>{!! nl2br(e($about['about_story'] ?? '')) !!}</p>
                    </div>
                    <div class="about-card">
                        <h3>Mission</h3>
                        <p>{!! nl2br(e($about['about_mission'] ?? '')) !!}</p>
                    </div>
                    <div class="about-card">
                        <h3>Vision</h3>
                        <p>{!! nl2br(e($about['about_vision'] ?? '')) !!}</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About -->
