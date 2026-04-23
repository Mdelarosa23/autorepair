@php($items = \App\Models\FaqItem::publicItems())

<!-- Faq -->
<section class="faq-area pb-70" id="faq">
    <div class="container">
        <div class="row faq-wrap">
            <div class="col-lg-12">
                <div class="faq-head">
                    <h2>Frequently Asked Questions</h2>
                </div>
                <div class="faq-item">
                    <ul class="accordion">
                        @foreach ($items as $item)
                            <li>
                                <a>{{ $item->question }}</a>
                                <p>{{ $item->answer }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Faq -->
