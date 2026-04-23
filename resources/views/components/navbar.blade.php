    <!-- Start Navbar Area -->
    <div class="navbar-area fixed-top">
        <!-- Menu For Mobile Device -->
        <div class="mobile-nav">
            <a href="#home" class="logo">
                <img src="assets/img/logo.png" alt="Logo">
            </a>
        </div>

        <!-- Menu For Desktop Device -->
        <div class="main-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="#home">
                        <img src="assets/img/logo.png" class="logo-one" alt="Logo">
                        <img src="assets/img/logo-two.png" class="logo-two" alt="Logo">
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="#home" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="#services" class="nav-link">Services</a>
                            </li>
                            <li class="nav-item">
                                <a href="#why-us" class="nav-link">Why Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="#works" class="nav-link">Works</a>
                            </li>
                            <li class="nav-item">
                                <a href="#about-us" class="nav-link">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="#faq" class="nav-link">FAQ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="cmn-btn">
                        <a class="banner-btn-left" href="{{ $siteContact['request_tow_url'] }}" target="_blank">
                            <i class='bx bxs-truck'></i>
                            {{ $siteContact['request_tow_label'] }}
                        </a>
                        <a class="banner-btn-left" href="{{ $siteContact['call_now_href'] }}" style="color: #fdb819;background: #ffffff">
                            <i class='bx bx-phone-call'></i>
                            CALL NOW
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- End Navbar Area -->
