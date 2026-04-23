<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqItem;
use App\Models\HomeSlide;
use App\Models\ProcessStep;
use App\Models\PublicVisit;
use App\Models\Service;
use App\Models\WhyUsItem;
use App\Models\WorkItem;
use Illuminate\Support\Facades\Schema;

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

        $now = now();
        $dailyIpVisits = PublicVisit::uniqueIpCountForDay($now);
        $monthlyIpVisits = PublicVisit::uniqueIpCountForMonth($now);
        $yearlyIpVisits = PublicVisit::uniqueIpCountForYear($now);
        $last30DaysIpVisits = PublicVisit::uniqueIpCountBetween($now->copy()->subDays(29), $now);
        $allTimeUniqueIps = PublicVisit::totalUniqueIpCount();

        return view('admin.dashboard', [
            'contentSections' => $contentSections,
            'stats' => [
                ['label' => 'Daily Unique IP Visits', 'value' => $dailyIpVisits],
                ['label' => 'Monthly Unique IP Visits', 'value' => $monthlyIpVisits],
                ['label' => 'Yearly Unique IP Visits', 'value' => $yearlyIpVisits],
                ['label' => 'Last 30 Days Unique IPs', 'value' => $last30DaysIpVisits],
                ['label' => 'All-Time Unique IPs', 'value' => $allTimeUniqueIps],
                ['label' => 'Active Home Slides', 'value' => $this->activeCountIfTableExists('home_slides', HomeSlide::class)],
                ['label' => 'Active Services', 'value' => $this->activeCountIfTableExists('services', Service::class)],
                ['label' => 'Active Process Steps', 'value' => $this->activeCountIfTableExists('process_steps', ProcessStep::class)],
                ['label' => 'Active Why Us Items', 'value' => $this->activeCountIfTableExists('why_us_items', WhyUsItem::class)],
                ['label' => 'Active Work Items', 'value' => $this->activeCountIfTableExists('work_items', WorkItem::class)],
                ['label' => 'Active FAQ Items', 'value' => $this->activeCountIfTableExists('faq_items', FaqItem::class)],
                ['label' => 'Logged In As', 'value' => auth()->user()->email],
            ],
        ]);
    }

    protected function activeCountIfTableExists(string $table, string $modelClass): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        return (int) $modelClass::query()->where('is_active', true)->count();
    }
}
