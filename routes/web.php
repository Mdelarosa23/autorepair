<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AboutUsSettingsController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ContactSettingsController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqItemController;
use App\Http\Controllers\Admin\HomeSlideController;
use App\Http\Controllers\Admin\ProcessStepController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\WhyUsItemController;
use App\Http\Controllers\Admin\WorkItemController;
use App\Models\HomeSlide;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/api/health', function () {
    return response()->json([
        'app' => config('app.name'),
        'framework' => 'Laravel',
        'frontend' => 'Blade template mirror',
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::get('/', function () {
    $firstSlide = HomeSlide::publicItems()->first();

    return view('home', [
        'seo' => [
            'title' => SiteSetting::seoDefaults()['title'],
            'description' => Str::limit(
                trim((string) ($firstSlide->description ?? '')) ?: SiteSetting::seoDefaults()['description'],
                155
            ),
            'canonical' => url('/'),
        ],
    ]);
});

Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\n\nSitemap: " . url('/sitemap.xml') . "\n", 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
});

Route::get('/sitemap.xml', function () {
    $lastModified = optional(HomeSlide::query()->latest('updated_at')->first())->updated_at?->toAtomString()
        ?? now()->toAtomString();

    return response()->view('sitemap', [
        'urls' => [
            [
                'loc' => url('/'),
                'lastmod' => $lastModified,
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
        ],
    ])->header('Content-Type', 'application/xml; charset=UTF-8');
});
Route::redirect('/login', '/admin/login')->name('login');

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'store'])->name('admin.login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', DashboardController::class)->name('admin.dashboard');
        Route::get('/content/{section?}', [ContentController::class, 'index'])->name('admin.content');

        Route::get('/home-slides', [HomeSlideController::class, 'index'])->name('admin.home-slides.index');
        Route::post('/home-slides', [HomeSlideController::class, 'store'])->name('admin.home-slides.store');
        Route::get('/home-slides/{homeSlide}/edit', [HomeSlideController::class, 'edit'])->name('admin.home-slides.edit');
        Route::put('/home-slides/{homeSlide}', [HomeSlideController::class, 'update'])->name('admin.home-slides.update');
        Route::delete('/home-slides/{homeSlide}', [HomeSlideController::class, 'destroy'])->name('admin.home-slides.destroy');

        Route::get('/process-steps', [ProcessStepController::class, 'index'])->name('admin.process-steps.index');
        Route::post('/process-steps', [ProcessStepController::class, 'store'])->name('admin.process-steps.store');
        Route::get('/process-steps/{processStep}/edit', [ProcessStepController::class, 'edit'])->name('admin.process-steps.edit');
        Route::put('/process-steps/{processStep}', [ProcessStepController::class, 'update'])->name('admin.process-steps.update');
        Route::delete('/process-steps/{processStep}', [ProcessStepController::class, 'destroy'])->name('admin.process-steps.destroy');

        Route::get('/services', [ServiceController::class, 'index'])->name('admin.services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

        Route::get('/why-us', [WhyUsItemController::class, 'index'])->name('admin.why-us.index');
        Route::post('/why-us', [WhyUsItemController::class, 'store'])->name('admin.why-us.store');
        Route::get('/why-us/{whyU}/edit', [WhyUsItemController::class, 'edit'])->name('admin.why-us.edit');
        Route::put('/why-us/{whyU}', [WhyUsItemController::class, 'update'])->name('admin.why-us.update');
        Route::delete('/why-us/{whyU}', [WhyUsItemController::class, 'destroy'])->name('admin.why-us.destroy');

        Route::get('/work-items', [WorkItemController::class, 'index'])->name('admin.work-items.index');
        Route::post('/work-items', [WorkItemController::class, 'store'])->name('admin.work-items.store');
        Route::get('/work-items/{workItem}/edit', [WorkItemController::class, 'edit'])->name('admin.work-items.edit');
        Route::put('/work-items/{workItem}', [WorkItemController::class, 'update'])->name('admin.work-items.update');
        Route::delete('/work-items/{workItem}', [WorkItemController::class, 'destroy'])->name('admin.work-items.destroy');

        Route::get('/faq-items', [FaqItemController::class, 'index'])->name('admin.faq-items.index');
        Route::post('/faq-items', [FaqItemController::class, 'store'])->name('admin.faq-items.store');
        Route::get('/faq-items/{faqItem}/edit', [FaqItemController::class, 'edit'])->name('admin.faq-items.edit');
        Route::put('/faq-items/{faqItem}', [FaqItemController::class, 'update'])->name('admin.faq-items.update');
        Route::delete('/faq-items/{faqItem}', [FaqItemController::class, 'destroy'])->name('admin.faq-items.destroy');

        Route::get('/about-us', [AboutUsSettingsController::class, 'edit'])->name('admin.about-us.edit');
        Route::post('/about-us', [AboutUsSettingsController::class, 'update'])->name('admin.about-us.update');

        Route::get('/contact-settings', [ContactSettingsController::class, 'edit'])->name('admin.contact-settings.edit');
        Route::post('/contact-settings', [ContactSettingsController::class, 'update'])->name('admin.contact-settings.update');

        Route::get('/theme', [ThemeController::class, 'edit'])->name('admin.theme.edit');
        Route::post('/theme', [ThemeController::class, 'update'])->name('admin.theme.update');
        Route::get('/change-password', [ChangePasswordController::class, 'edit'])->name('admin.password.edit');
        Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('admin.password.update');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
    });
});
