@php($items = \App\Models\WorkItem::publicItems())
@php(
    $categories = [
        'wheel' => 'Wheel',
        'steering' => 'Steering',
        'brakes' => 'Brakes',
        'suspension' => 'Suspension',
        'tyre' => 'Tyre',
        'tow' => 'Tow',
    ]
)
@php(
    $resolveCategory = function (?string $value) use ($categories) {
        $normalized = strtolower(trim((string) $value));

        return match (true) {
            isset($categories[$normalized]) => $normalized,
            str_contains($normalized, 'web') => 'steering',
            str_contains($normalized, 'ui') => 'brakes',
            str_contains($normalized, 'ux') => 'suspension',
            str_contains($normalized, 'branding') => 'tyre',
            str_contains($normalized, 'tow') => 'tow',
            str_contains($normalized, 'wheel') || str_contains($normalized, 'tyre') => 'wheel',
            default => 'wheel',
        };
    }
)
@php($theme = \App\Models\SiteSetting::themeSettings())
<!-- Work -->
<section class="work-area pt-100 pb-70" id="works">
    <style>
        .work-area .work-view-btn {
            padding: 10px 20px;
            border-radius: 5px;
            background: {{ $theme['light_accent'] }};
            border: 0;
            color: {{ $theme['light_background'] }};
            font: inherit;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .work-area .work-item .cmn-btn .work-view-btn i {
            font-size: 22px;
        }

        .work-viewer {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 28px;
            background:
                radial-gradient(circle at top, rgba(253, 184, 25, 0.18), transparent 32%),
                rgba(9, 14, 23, 0.9);
            backdrop-filter: blur(10px);
        }

        .work-viewer.open {
            display: flex;
        }

        .work-viewer-dialog {
            position: relative;
            width: min(1180px, 100%);
            min-height: min(78vh, 760px);
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            overflow: hidden;
            border-radius: 28px;
            background: #ffffff;
            box-shadow: 0 35px 90px rgba(0, 0, 0, 0.35);
        }

        .work-viewer-media {
            position: relative;
            min-height: 540px;
            /* padding: 24px; */
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(135deg, rgba(17, 24, 39, 0.04), rgba(17, 24, 39, 0.12)),
                repeating-linear-gradient(
                    -45deg,
                    rgba(17, 24, 39, 0.03),
                    rgba(17, 24, 39, 0.03) 16px,
                    rgba(255, 255, 255, 0.55) 16px,
                    rgba(255, 255, 255, 0.55) 32px
                );
        }

        .work-viewer-media::after {
            content: "";
            position: absolute;
            inset: 24px;
            /* border-radius: 24px; */
            /* border: 1px solid rgba(255, 255, 255, 0.55); */
            pointer-events: none;
        }

        .work-viewer-image {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 100%;
            max-height: calc(85vh - 48px);
            object-fit: contain;
            /* border-radius: 22px; */
            box-shadow: 0 20px 55px rgba(15, 23, 42, 0.18);
            background: #fff;
        }

        .work-viewer-close {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 48px;
            height: 48px;
            border: 0;
            border-radius: 999px;
            background: rgba(17, 24, 39, 0.82);
            color: #fff;
            font-size: 30px;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
            z-index: 3;
        }

        .work-viewer-sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 34px 28px 28px;
            background: linear-gradient(180deg, #0f172a 0%, #172033 100%);
            color: #fff;
        }

        .work-viewer-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(253, 184, 25, 0.14);
            color: {{ $theme['light_accent'] }};
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .work-viewer-caption {
            margin-top: 22px;
        }

        .work-viewer-caption strong,
        .work-viewer-caption span,
        .work-viewer-note span,
        .work-viewer-note strong {
            display: block;
        }

        .work-viewer-caption strong {
            font-size: 30px;
            line-height: 1.15;
        }

        .work-viewer-caption span {
            margin-top: 10px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 15px;
            line-height: 1.6;
        }

        .work-viewer-note {
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .work-viewer-note strong {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .work-viewer-note span {
            color: rgba(255, 255, 255, 0.68);
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 991px) {
            .work-viewer {
                padding: 18px;
            }

            .work-viewer-dialog {
                grid-template-columns: 1fr;
                min-height: auto;
                max-height: calc(100vh - 36px);
                overflow: auto;
            }

            .work-viewer-media {
                min-height: 360px;
                padding: 18px;
            }

            .work-viewer-media::after {
                inset: 18px;
            }

            .work-viewer-image {
                max-height: 58vh;
            }

            .work-viewer-sidebar {
                padding: 24px 20px;
            }

            .work-viewer-caption strong {
                font-size: 24px;
            }
        }

        @media (max-width: 575px) {
            .work-viewer {
                padding: 12px;
            }

            .work-viewer-dialog {
                border-radius: 20px;
            }

            .work-viewer-media {
                min-height: 280px;
                padding: 14px;
            }

            .work-viewer-media::after {
                inset: 14px;
                /* border-radius: 18px; */
            }

            .work-viewer-close {
                top: 12px;
                right: 12px;
                width: 42px;
                height: 42px;
                font-size: 24px;
            }
        }
    </style>

    <div class="container">
        <div class="section-title">
            <span class="sub-title">works</span>
            <h2>Latest Works For Clients</h2>
            <p>Browse recent repair jobs and featured work completed by our team.</p>
        </div>
        <div class="sorting-menu">
            <ul>
                <li class="filter active" data-filter="all">All</li>
                @foreach ($categories as $key => $label)
                    <li class="filter" data-filter=".{{ $key }}">{{ $label }}</li>
                @endforeach
            </ul>
        </div>
        <div id="Container" class="row">
            @foreach ($items as $item)
                @php($path = $item->image_path ?? '')
                @php($imageUrl = str_starts_with($path, 'assets/img/') ? asset(ltrim($path, '/')) : asset(ltrim($path, '/')))
                @php($categoryKey = $resolveCategory($item->filter_classes))
                <div class="{{ $item->column_class }} mix {{ $categoryKey }}">
                    <div class="work-item">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title ?: 'Work' }}">
                        <div class="cmn-btn">
                            <button
                                type="button"
                                class="work-view-btn banner-btn-left"
                                data-work-view
                                data-image="{{ $imageUrl }}"
                                data-title="{{ $item->title ?: 'Work Image' }}"
                                data-category="{{ $categories[$categoryKey] }}"
                            >
                                View
                                <i class='bx bx-right-arrow-alt'></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="work-viewer" id="work-image-viewer" aria-hidden="true">
        <div class="work-viewer-dialog">
            <button type="button" class="work-viewer-close" data-work-view-close aria-label="Close image viewer">&times;</button>
            <div class="work-viewer-media">
                <img src="" alt="" class="work-viewer-image" id="work-viewer-image">
            </div>
            <div class="work-viewer-sidebar">
                <div>
                    <div class="work-viewer-eyebrow">Client Work</div>
                    <div class="work-viewer-caption">
                        <strong id="work-viewer-title">Work Image</strong>
                        <span id="work-viewer-category"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var viewer = document.getElementById('work-image-viewer');
            var image = document.getElementById('work-viewer-image');
            var title = document.getElementById('work-viewer-title');
            var category = document.getElementById('work-viewer-category');

            if (!viewer || !image || !title || !category) {
                return;
            }

            function closeViewer() {
                viewer.classList.remove('open');
                viewer.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('[data-work-view]').forEach(function (button) {
                button.addEventListener('click', function () {
                    image.src = button.dataset.image || '';
                    image.alt = button.dataset.title || 'Work Image';
                    title.textContent = button.dataset.title || 'Work Image';
                    category.textContent = button.dataset.category || '';
                    viewer.classList.add('open');
                    viewer.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                });
            });

            viewer.addEventListener('click', function (event) {
                if (event.target === viewer || event.target.hasAttribute('data-work-view-close')) {
                    closeViewer();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && viewer.classList.contains('open')) {
                    closeViewer();
                }
            });
        })();
    </script>
</section>
<!-- End Work -->
