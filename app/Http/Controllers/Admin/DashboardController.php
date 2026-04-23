<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $contentSections = [
            ['label' => 'Home Slider', 'slug' => 'home-slider'],
            ['label' => 'Process', 'slug' => 'process'],
            ['label' => 'Services', 'slug' => 'services'],
            ['label' => 'Why Us', 'slug' => 'why-us'],
            ['label' => 'Works', 'slug' => 'works'],
            ['label' => 'About Us', 'slug' => 'about-us'],
            ['label' => 'FAQ', 'slug' => 'faq'],
            ['label' => 'Contact & CTA', 'slug' => 'contact-cta'],
        ];

        return view('admin.dashboard', [
            'contentSections' => $contentSections,
            'stats' => [
                ['label' => 'Public Sections', 'value' => count($contentSections)],
                ['label' => 'Content Groups', 'value' => 1],
                ['label' => 'Logged In As', 'value' => auth()->user()->email],
            ],
        ]);
    }
}
