@extends('layouts.app')

@section('content')

    <main role="main" class="probootstrap-main js-probootstrap-main">


        <div id="photo-loader" style="display: none; text-align: center; padding: 20px;">
            <i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #333;"></i>
            <p>Loading new photos...</p>
        </div>

        <button id="manual-refresh-btn" class="refresh-button btn btn-primary mb-3 ml-3" aria-label="Refresh">
            <i class="fa fa-refresh mr-1"></i> Refresh
        </button>


        <div class="probootstrap-bar">
            <a href="#" class="probootstrap-toggle js-probootstrap-toggle"><span class="fa fa-bars"></span></a>
            <div class="d-flex justify-content-center align-items-start" style="height: 80px; ">
                {{-- <a href="index.html" class="probootstrap-logo">MuseumCam</a> --}}
            </div>
        </div>


        <div class="card-columns" id="photo-container">
            @forelse($captures as $capture)
                <div class="card img-loaded image-preview-link">
                    <a href="#">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                            src="{{ asset('storage/images/' . $capture->filename) }}" alt="Photo"
                            data-full-src="{{ asset('storage/images/' . $capture->filename) }}">
                    </a>
                </div>
            @empty
                <div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
                    <p class="text-center mb-0">No photos captured yet.</p>
                </div>
            @endforelse
        </div>



        <div class="container-fluid d-md-none">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-unstyled d-flex probootstrap-aside-social">
                        <li><a href="" class="p-2"><span class="fa fa-github"></span></a></li>
                        <li><a href="#" class="p-2"><span class="fa fa-instagram"></span></a></li>
                        <li><a href="#" class="p-2"><span class="fa fa-linkedin"></span></a></li>
                    </ul>
                    <p>© 2025 <a target="_blank">MuseumCam</a>. <br> All
                        Rights
                        Reserved.
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
