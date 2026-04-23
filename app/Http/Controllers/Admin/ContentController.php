<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;

class ContentController extends Controller
{
    public function index(?string $section = null)
    {
        $sections = [
            'home-slider' => [
                'title' => 'Home Slider',
                'description' => 'Manage the headline, supporting copy, and call-to-action buttons shown in the homepage slider.',
                'manage_url' => route('admin.home-slides.index'),
                'manage_label' => 'Manage Home Slider',
            ],
            'process' => [
                'title' => 'Process',
                'description' => 'Update the step-by-step process content that explains how your team works.',
                'manage_url' => route('admin.process-steps.index'),
                'manage_label' => 'Manage Process',
            ],
            'services' => [
                'title' => 'Services',
                'description' => 'Review and organize the services listed on the public website.',
                'manage_url' => route('admin.services.index'),
                'manage_label' => 'Manage Services',
            ],
            'why-us' => [
                'title' => 'Why Us',
                'description' => 'Maintain the trust-building section that highlights why customers choose your business.',
                'manage_url' => route('admin.why-us.index'),
                'manage_label' => 'Manage Why Us',
            ],
            'works' => [
                'title' => 'Works',
                'description' => 'Showcase past work, featured projects, and photo-based proof of completed jobs.',
                'manage_url' => route('admin.work-items.index'),
                'manage_label' => 'Manage Works',
            ],
            'about-us' => [
                'title' => 'About Us',
                'description' => 'Manage your mission, vision, shop story, and the About Us image shown before FAQ.',
                'manage_url' => route('admin.about-us.edit'),
                'manage_label' => 'Manage About Us',
                'summary' => SiteSetting::aboutUsSettings(),
            ],
            'faq' => [
                'title' => 'FAQ',
                'description' => 'Edit the common questions and answers customers read before getting in touch.',
                'manage_url' => route('admin.faq-items.index'),
                'manage_label' => 'Manage FAQ',
            ],
            'contact-cta' => [
                'title' => 'Contact & CTA',
                'description' => 'Manage the main call number, towing link, towing service phone number, and working hours used across the website.',
                'manage_url' => route('admin.contact-settings.edit'),
                'manage_label' => 'Manage Contact & CTA',
                'summary' => SiteSetting::contactSettings(),
            ],
        ];

        $selectedKey = $section ?: array_key_first($sections);

        abort_unless(isset($sections[$selectedKey]), 404);

        return view('admin.content.index', [
            'sections' => $sections,
            'selectedKey' => $selectedKey,
            'selectedSection' => $sections[$selectedKey],
        ]);
    }
}
