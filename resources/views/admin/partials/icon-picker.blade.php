@php
    $icons = [
        'bx bxs-wrench' => 'Wrench',
        'bx bxs-cog' => 'Cog',
        'bx bxs-disc' => 'Disc',
        'bx bxs-bolt' => 'Bolt',
        'bx bxs-thermometer' => 'Temp',
        'bx bxs-droplet' => 'Oil',
        'bx bxs-car' => 'Car',
        'bx bxs-truck' => 'Truck',
        'bx bxs-car-mechanic' => 'Mechanic',
        'bx bxs-car-garage' => 'Garage',
        'bx bxs-car-crash' => 'Crash',
        'bx bxs-car-wash' => 'Wash',
        'bx bx-box' => 'Box',
        'bx bx-money' => 'Money',
        'bx bx-heart' => 'Heart',
        'bx bxs-badge-check' => 'Certified',
        'bx bxs-battery' => 'Battery',
        'bx bxs-star' => 'Star',
    ];
@endphp
<div data-icon-picker>
    <input type="hidden" name="{{ $name }}" value="{{ $selected }}">
    <div class="icon-picker">
        @foreach ($icons as $value => $label)
            <button type="button" class="icon-option {{ $selected === $value ? 'active' : '' }}" data-icon-value="{{ $value }}">
                <i class="{{ $value }}"></i>
                <span>{{ $label }}</span>
            </button>
        @endforeach
    </div>
</div>
