@extends('layouts.app')

@section('content')
  <div class="container">
    <h2 class="mb-4">My Photos</h2>

    <div id="photo-feed">
      @foreach ($captures as $capture)
        <div class="photo-item mb-3">
          <img
            src="{{ asset('storage/captures/' . $capture->filename) }}"
            alt="Photo"
            class="img-fluid"
            onclick="openFull('{{ asset('storage/captures/' . $capture->filename) }}')"
          >
        </div>
      @endforeach
    </div>

    <div class="text-center mt-4">
      <button onclick="refreshFeed()" class="btn btn-dark">🔄 Refresh</button>
    </div>
  </div>

  <!-- Full Image Modal -->
  <div id="fullImageModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:white; z-index:1000;">
    <div class="text-center p-4">
      <img id="fullImageSrc" src="" style="max-width:100%; max-height:80vh;">
      <p>📲 Long-press the image and tap "Save to camera roll"</p>
      <button class="btn btn-secondary mt-2" onclick="closeFull()">Close</button>
    </div>
  </div>

  <script>
    function openFull(src) {
      document.getElementById('fullImageSrc').src = src;
      document.getElementById('fullImageModal').style.display = 'block';
    }

    function closeFull() {
      document.getElementById('fullImageModal').style.display = 'none';
    }



    // Auto-refresh every 20 seconds + on focus
    setInterval(refreshFeed, 20000);
    window.addEventListener('focus', refreshFeed);
  </script>
@endsection
