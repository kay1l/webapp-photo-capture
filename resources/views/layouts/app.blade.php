    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Aside - Free HTML5 Bootstrap 4 Template by uicookies.com</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Free HTML5 Website Template by uicookies.com">
        <meta name="keywords"
            content="free bootstrap 4, free bootstrap 4 template, free website templates, free html5, free template, free website template, html5, css3, mobile first, responsive">
        <meta name="author" content="uicookies.com">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/open-iconic-bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
        <meta name="robots" content="noindex, nofollow">
    </head>

    <body>

        @include('partials.sidebar')

        <main role="main" class="probootstrap-main js-probootstrap-main">

            <div id="photo-loader" style="display: none; text-align: center; padding: 20px;">
                <i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #333;"></i>
                <p>Loading new photos...</p>
            </div>

            {{-- <button id="manual-refresh-btn" class="refresh-button" aria-label="Refresh">
                <i class="fa fa-refresh"></i>
            </button> --}}

            <div class="probootstrap-bar">
                <a href="#" class="probootstrap-toggle js-probootstrap-toggle"><span
                        class="fa fa-bars"></span></a>
                <div class="probootstrap-main-site-logo"><a href="index.html">MuseumCam</a></div>
            </div>
            <div class="card-columns">
                <div class="card img-loaded image-preview-link" data-src="images/img_1.jpg">
                    <a href="#">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                             src="images/img_1.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_2.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_3.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_4.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_5.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_6.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_7.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_8.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_9.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_10.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_11.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_12.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_13.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_14.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_15.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_16.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="images/img_17.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_18.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_19.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_20.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card img-loaded">
                    <a href="#" class="image-preview-link">
                        <img class="card-img-top probootstrap-animate" src="images/img_21.jpg" alt="Card image cap">
                    </a>
                </div>
            </div>

            <div class="container-fluid d-md-none">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-unstyled d-flex probootstrap-aside-social">
                            <li><a href="#" class="p-2"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="#" class="p-2"><span class="fa fa-instagram"></span></a></li>
                            <li><a href="#" class="p-2"><span class="fa fa-linkedin"></span></a></li>
                        </ul>
                        <p>© 2017 <a href="https://uicookies.com/" target="_blank">uiCookies:Aside</a>. <br> All
                            Rights
                            Reserved. Designed by <a href="https://uicookies.com/" target="_blank">uicookies.com</a>
                        </p>
                    </div>
                </div>
            </div>

        @include('partials.shared-modal')

        <script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/photo.js') }}"></script>
        <script src="{{ asset('assets/js/refresh.js') }}"></script>

        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon='{"rayId":"95cc2a000e3efd22","version":"2025.6.2","r":1,"token":"1aea4905526a46c1a4fc9bc1d0e89a42","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}}}'
            crossorigin="anonymous"></script>

    </body>

    </html>
