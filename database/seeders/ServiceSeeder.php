<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Engine Repair & Swaps',
                'description' => 'Full engine diagnostics, rebuilds, and swaps for all makes and models.',
                'icon_class' => 'bx bxs-wrench',
                'image_path' => 'assets/img/home-one/service/1.jpg',
                'link_url' => '#services',
                'sort_order' => 1,
            ],
            [
                'title' => 'Transmission Service',
                'description' => 'Transmission repair, rebuilds, and replacements for manual and automatic vehicles.',
                'icon_class' => 'bx bxs-cog',
                'image_path' => 'assets/img/home-one/service/2.jpg',
                'link_url' => '#services',
                'sort_order' => 2,
            ],
            [
                'title' => 'Brakes & Rotors',
                'description' => 'Brake pads, rotors, calipers, and complete brake system overhauls.',
                'icon_class' => 'bx bxs-disc',
                'image_path' => 'assets/img/home-one/service/3.jpg',
                'link_url' => '#services',
                'sort_order' => 3,
            ],
            [
                'title' => 'Electrical & Diagnostics',
                'description' => 'Computer diagnostics, wiring repair, alternators, and starter troubleshooting.',
                'icon_class' => 'bx bxs-bolt',
                'image_path' => 'assets/img/home-one/service/4.jpg',
                'link_url' => '#services',
                'sort_order' => 4,
            ],
            [
                'title' => 'A/C & Heating',
                'description' => 'Complete climate control service to keep your vehicle comfortable year-round.',
                'icon_class' => 'bx bxs-thermometer',
                'image_path' => 'assets/img/home-one/service/5.jpg',
                'link_url' => '#services',
                'sort_order' => 5,
            ],
            [
                'title' => 'Oil Change & Maintenance',
                'description' => 'Routine oil changes, filters, fluids, and maintenance checks.',
                'icon_class' => 'bx bxs-droplet',
                'image_path' => 'assets/img/home-one/service/6.jpg',
                'link_url' => '#services',
                'sort_order' => 6,
            ],
            [
                'title' => 'Suspension & Steering',
                'description' => 'Shocks, struts, ball joints, tie rods, and complete suspension repairs.',
                'icon_class' => 'bx bxs-car',
                'image_path' => 'assets/img/home-one/service/6.jpg',
                'link_url' => '#services',
                'sort_order' => 7,
            ],
            [
                'title' => 'Towing Service',
                'description' => 'Flatbed towing, roadside assistance, and emergency recovery from 8AM to 8PM.',
                'icon_class' => 'bx bxs-truck',
                'image_path' => 'assets/img/home-one/service/6.jpg',
                'link_url' => '#services',
                'sort_order' => 8,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['title' => $service['title']],
                $service + ['is_active' => true]
            );
        }
    }
}
