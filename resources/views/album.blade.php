@extends('layouts.app')

@section('content')
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


    {{-- <div class="card-columns">
        @forelse($captures as $capture)
            <div class="card img-loaded image-preview-link">
                <a href="#">
                    <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                         src="{{ asset('storage/photos/' . $capture->filename) }}"
                         alt="Photo"
                         data-full-src="{{ asset('storage/photos/' . $capture->filename) }}">
                </a>
            </div>
        @empty
            <div class="card text-center">
                <div class="card-body">
                    <p>No photos captured yet.</p>
                </div>
            </div>
        @endforelse
    </div>--}}




    <div class="card-columns">
        <div class="card img-loaded image-preview-link" data-full-src="images/img_1.jpg">
            <a href="#">
                <img class="card-img-top  probootstrap-animate fadeInUp probootstrap-animated"
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
</main>

@endsection
