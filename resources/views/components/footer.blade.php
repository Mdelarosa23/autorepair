    <!-- Footer -->
    <footer class="footer-area">
        <div class="footer-img">
            <img src="assets/img/home-one/footer-car.png" alt="Footer">
        </div>

        <div class="container">
            <div class="footer-cta text-center">
                <h2>Ready to Get Your Car Fixed Right?</h2>
                <p>
                    Don't wait until a small problem becomes a big one. Call Mads Auto Repair today and experience
                    honest, affordable service that keeps Nashville moving.
                </p>

                <div class="cmn-btn">
                    <a class="banner-btn-left" href="{{ $siteContact['call_now_href'] }}" style="color: #fdb819;background: #ffffff;font-size: 20px;padding-right: 25px;padding-left: 25px;padding-top: 20px;padding-bottom: 20px">
                        <i class='bx bx-phone-call'></i>
                        CALL NOW - {{ $siteContact['call_now_number'] }}
                    </a>
                    <a class="banner-btn-left" href="{{ $siteContact['request_tow_url'] }}" target="_blank" style="font-size: 20px;padding-right: 25px;padding-left: 25px;padding-top: 20px;padding-bottom: 20px">
                        <i class='bx bxs-truck'></i>
                        {{ $siteContact['request_tow_label'] }}
                    </a>

                </div>
            </div>

            <div class="row footer-info">
                <div class="col-md-4">
                    <h4><i class='bx bxs-map'></i> Location</h4>
                    <p>1206 Gallatin Pike S<br>Madison, TN 37115</p>
                </div>

                <div class="col-md-4">
                    <h4><i class='bx bxs-phone'></i> Contact</h4>
                    <p>{{ $siteContact['call_now_number'] }}<br>repairmads@gmail.com</p>
                </div>

                <div class="col-md-4">
                    <h4><i class='bx bxs-time'></i> Hours</h4>
                    <p>{{ $siteContact['working_hours'] }}</p>
                </div>
            </div>

            <div class="copyright-area text-center">
                <p>&copy; 2026 Mads Auto Repair. All rights reserved. | 1206 Gallatin Pike S, Madison, TN 37115.</p>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
