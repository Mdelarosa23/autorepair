@php
    $steps = \App\Models\ProcessStep::publicItems()->values();
    $leftSteps = $steps->take(2)->values();
    $rightSteps = $steps->slice(2, 2)->values();
    $leftClasses = ['process-one', ''];
    $rightClasses = ['process-two', 'process-three'];
@endphp

<!-- Process -->
<section class="process-area process-area-two pt-100 pb-70">
    <div class="process-shape">
        <img src="assets/img/home-one/car-shadow.png" alt="Shape">
    </div>
    <div class="section-title">
        <span class="sub-title">Process</span>
        <h2>Our Working Process</h2>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="process-item">
                    @foreach ($leftSteps as $index => $step)
                        <div class="process-inner {{ $leftClasses[$index] ?? '' }}">
                            <i class='{{ $step->icon_class }}'></i>
                            <h3>{{ $step->title }}</h3>
                            <p>{{ $step->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4" style="align-content: center;">
                <div class="process-item">
                    <div class="process-img">
                        <img src="assets/img/home-two/work-two.png" alt="Process">
                        <img src="assets/img/home-two/work-one.png" alt="Process">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="process-item">
                    @foreach ($rightSteps as $index => $step)
                        <div class="process-inner {{ $rightClasses[$index] ?? '' }}">
                            <i class='{{ $step->icon_class }}'></i>
                            <h3>{{ $step->title }}</h3>
                            <p>{{ $step->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Process -->
