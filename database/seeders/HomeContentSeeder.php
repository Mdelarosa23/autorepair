<?php

namespace Database\Seeders;

use App\Models\FaqItem;
use App\Models\HomeSlide;
use App\Models\ProcessStep;
use App\Models\WhyUsItem;
use App\Models\WorkItem;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'title' => "Nashville's Most Trusted Auto Repair",
                'highlight_text' => 'Trusted',
                'hook_message' => 'NEED A TOW? CALL US NOW (615-705-4200)',
                'hook_highlight_text' => 'CALL US NOW',
                'description' => 'Honest repairs. Fair prices. Same-day service when you need it most. Domestic and foreign vehicles, we handle it all.',
                'primary_label' => '(615) 705-0737',
                'primary_url' => 'tel:+6157050737',
                'secondary_label' => 'REQUEST A TOW',
                'secondary_url' => 'https://public.towbook.com/PO3A',
                'sort_order' => 1,
            ],
        ] as $item) {
            HomeSlide::query()->updateOrCreate(['title' => $item['title']], $item + ['is_active' => true]);
        }

        foreach ([
            ['title' => 'Identify Problems', 'description' => 'We perform a full inspection to accurately diagnose any issues with your vehicle.', 'icon_class' => 'bx bxs-car-mechanic', 'sort_order' => 1],
            ['title' => 'Start Servicing', 'description' => 'Our technicians begin repairs using the right tools, parts, and proven methods.', 'icon_class' => 'bx bxs-car-garage', 'sort_order' => 2],
            ['title' => 'Trial For Make Sure', 'description' => 'We test and verify everything to ensure safety, performance, and reliability.', 'icon_class' => 'bx bxs-car-crash', 'sort_order' => 3],
            ['title' => 'Deliver Service', 'description' => 'Your vehicle is returned in top condition, ready for the road with confidence.', 'icon_class' => 'bx bxs-car-wash', 'sort_order' => 4],
        ] as $item) {
            ProcessStep::query()->updateOrCreate(['title' => $item['title']], $item + ['is_active' => true]);
        }

        foreach ([
            ['title' => 'Honest & Transparent', 'description' => 'No hidden fees, no upselling. We tell you exactly what your car needs and nothing more.', 'icon_class' => 'bx bx-box', 'sort_order' => 1],
            ['title' => 'Same-Day Service', 'description' => 'Broke down on a road trip? We have gotten countless travelers back on the road the same day.', 'icon_class' => 'bx bxs-truck', 'sort_order' => 2],
            ['title' => 'Fair Prices', 'description' => 'Extremely reasonable rates that will not break the bank. Quality work does not have to cost a fortune.', 'icon_class' => 'bx bx-money', 'sort_order' => 3],
            ['title' => 'We Treat You Like Family', 'description' => 'Read our reviews. Our customers are not just satisfied, they are grateful. We go above and beyond.', 'icon_class' => 'bx bx-heart', 'sort_order' => 4],
            ['title' => 'Master ASE Certified', 'description' => 'Our lead technician is Master ASE certified. Your vehicle is in expert hands.', 'icon_class' => 'bx bxs-badge-check', 'sort_order' => 5],
            ['title' => 'Domestic & Foreign', 'description' => 'Prius to Trans Am, Mercedes to motorhome. If it has wheels, we can fix it.', 'icon_class' => 'bx bxs-car', 'sort_order' => 6],
        ] as $item) {
            WhyUsItem::query()->updateOrCreate(['title' => $item['title']], $item + ['is_active' => true]);
        }

        foreach ([
            ['title' => 'Wheel Work', 'image_path' => 'assets/img/home-one/work/1.jpg', 'link_url' => '#works', 'filter_classes' => 'web ui', 'column_class' => 'col-sm-6 col-lg-3', 'sort_order' => 1],
            ['title' => 'Suspension Work', 'image_path' => 'assets/img/home-one/work/2.jpg', 'link_url' => '#works', 'filter_classes' => 'tyre ux', 'column_class' => 'col-sm-6 col-lg-3', 'sort_order' => 2],
            ['title' => 'Brake Project', 'image_path' => 'assets/img/home-one/work/3.jpg', 'link_url' => '#works', 'filter_classes' => 'ui branding', 'column_class' => 'col-sm-6 col-lg-6', 'sort_order' => 3],
            ['title' => 'Alignment Repair', 'image_path' => 'assets/img/home-one/work/4.jpg', 'link_url' => '#works', 'filter_classes' => 'ux tyre', 'column_class' => 'col-sm-6 col-lg-3', 'sort_order' => 4],
            ['title' => 'Steering Job', 'image_path' => 'assets/img/home-one/work/5.jpg', 'link_url' => '#works', 'filter_classes' => 'branding ui', 'column_class' => 'col-sm-6 col-lg-6', 'sort_order' => 5],
            ['title' => 'Tyre Service', 'image_path' => 'assets/img/home-one/work/6.jpg', 'link_url' => '#works', 'filter_classes' => 'tyre web', 'column_class' => 'col-sm-6 col-lg-3', 'sort_order' => 6],
        ] as $item) {
            WorkItem::query()->updateOrCreate(['title' => $item['title']], $item + ['is_active' => true]);
        }

        foreach ([
            ['question' => 'Do you work on all vehicle makes and models?', 'answer' => 'Yes. We service both domestic and foreign vehicles, from hybrids to classic cars and even motorhomes.', 'sort_order' => 1],
            ['question' => 'Do you offer same-day service?', 'answer' => 'In many cases, yes. We do our best to prioritize urgent repairs and get customers back on the road quickly.', 'sort_order' => 2],
            ['question' => 'How much do you charge for diagnostics?', 'answer' => 'We offer competitive diagnostic pricing. Call us for the latest rates and we will explain everything clearly.', 'sort_order' => 3],
            ['question' => 'Do you offer towing services?', 'answer' => 'Yes. We provide towing and roadside assistance throughout the area during business hours.', 'sort_order' => 4],
            ['question' => 'What forms of payment do you accept?', 'answer' => 'We accept cash, debit cards, and major credit cards.', 'sort_order' => 5],
            ['question' => 'Do I need an appointment?', 'answer' => 'Walk-ins are welcome, but for larger jobs we recommend calling ahead so we can prepare for your visit.', 'sort_order' => 6],
        ] as $item) {
            FaqItem::query()->updateOrCreate(['question' => $item['question']], $item + ['is_active' => true]);
        }
    }
}
