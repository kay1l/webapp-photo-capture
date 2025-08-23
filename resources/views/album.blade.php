@extends('layouts.app')

@section('content')
    <main role="main" class="probootstrap-main js-probootstrap-main">


        <div id="photo-loader" style="display: none; text-align: center; padding: 20px;">
            <i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #333;"></i>
            <p>Loading new photos...</p>
        </div>

        <div class="mb-6 ml-3" style="margin-bottom: 30px;">
            <button id="manual-refresh-btn" class="refresh-button btn btn-primary" aria-label="Refresh">
                <i class="fa fa-refresh mr-1"></i> Refresh
            </button>
        </div>

        <div class="probootstrap-bar">
            <a href="#" class="probootstrap-toggle js-probootstrap-toggle"><span class="fa fa-bars"></span></a>
            <div class="d-flex justify-content-center align-items-start" style="height: 80px; ">
                {{-- <a href="index.html" class="probootstrap-logo">MuseumCam</a> --}}
            </div>
        </div>

        <style>
            #photo-container {
                overflow: visible !important;
                padding-top: 20px;
            }

            .card {
                break-inside: avoid;

            }

            .card img {
                width: 100%;
                object-fit: contain;
                height: auto;
                display: block;
            }
        </style>

        <div class="card-columns" id="photo-container">
            @forelse($captures as $capture)
                <div class="card img-loaded image-preview-link">
                    <a href="#">
                        <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated img-fluid"
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
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const shouldPromptEmail = @json($promptEmail ?? false);

            if (shouldPromptEmail) {
                const modal = document.getElementById('sidebar-modal');
                const modalBody = document.getElementById('modal-body');

                modalBody.innerHTML = `
                    <h3><i class="fa fa-envelope mr-2"></i> Receive all my pictures</h3>
                    <p>Enter your email to receive your album link after your visit.</p>
                    <input type="email" id="email-input" placeholder="you@example.com" style="width:100%; padding:10px;" />
                    <button id="submit-email" style="margin-top:10px; background-color:#1FAD9F; color:white; padding:10px 20px; border:none; border-radius:4px;">Submit</button>
                `;
                modal.style.display = 'flex';

                setTimeout(() => {
                    document.getElementById('submit-email')?.addEventListener('click', () => {
                        const email = document.getElementById('email-input').value.trim();
                        const albumId = document.body.dataset.albumId;
                        const button = document.getElementById('submit-email');

                        if (!email) {
                            toastr.error("Please enter a valid email.");
                            return;
                        }

                        button.disabled = true;
                        button.innerHTML = `<span class="spinner" style="margin-right: 8px;"></span>Submitting...`;

                        fetch('/photographer/receive-link', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                album_id: albumId,
                                email
                            })
                        })
                        .then(async (res) => {
                            const text = await res.text();

                            try {
                                const data = JSON.parse(text);

                                if (res.ok && data.success) {
                                    modal.style.display = 'none';
                                    toastr.success(`You’ll receive your album link at ${email} after your visit.`);
                                } else {
                                    toastr.error(data.message || "Something went wrong.");
                                }

                            } catch (err) {
                                console.error("Invalid JSON response:", text);
                                toastr.error("Unexpected server response.");
                            }
                        })
                        .catch(err => {
                            console.error("Fetch failed:", err);
                            toastr.error("Server error. Please try again later.");
                        })
                        .finally(() => {
                            button.disabled = false;
                            button.innerHTML = 'Submit';
                        });

                    });
                }, 0);
            }
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tokenName = "user_access_token";

        // 🔁 Restore cookie from localStorage if it's missing
        const storedToken = localStorage.getItem(tokenName);
        const currentCookie = getCookie(tokenName);

        if (storedToken && !currentCookie) {
            document.cookie = `${tokenName}=${storedToken}; path=/; max-age=43200;`;
            location.reload(); // Reload so Laravel sees the restored cookie
        }

        // 📝 Save token from cookie to localStorage (only if not already stored)
        if (!storedToken && currentCookie) {
            localStorage.setItem(tokenName, currentCookie);
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }
    });
</script>


@endsection
