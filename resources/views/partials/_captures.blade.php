@foreach($captures as $capture)
    <div class="card img-loaded image-preview-link">
        <a href="#">
            <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                 src="{{ asset('storage/images/' . $capture->filename) }}"
                 alt="Photo"
                 data-full-src="{{ asset('storage/images/' . $capture->filename) }}">
        </a>
    </div>
@endforeach
