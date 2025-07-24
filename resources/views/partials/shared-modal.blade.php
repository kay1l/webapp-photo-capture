<style>
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }


    .modal-content {
        background: #fff;
        border-radius: 8px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        position: relative;
        text-align: center;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }

    #image-preview-container img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    @media (min-width: 768px) {
    #image-preview-container img {
        max-width: 600px;
        width: auto;
        height: auto;
        margin: 0 auto;
        display: block;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
    }
}

    #image-preview-text {
        color: white;
        margin-top: 1rem;
    }

    #image-preview-modal .modal-content {
        background: transparent;
        padding: 0;
        max-width: 90%;
    }

    #image-preview-modal .close-button {
        color: red;
        top: 5px;
        right: 10px;
    }

    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #fff;
        border-top: 2px solid #555;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        vertical-align: middle;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div id="sidebar-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-button" id="close-sidebar-modal">&times;</span>
        <div id="modal-body"></div>
    </div>
</div>

<div id="image-preview-modal" class="modal">
    <div class="modal-content" id="image-preview-container">
        <span class="close-button" id="close-image-preview">&times;</span>
        <img id="preview-image" src="" alt="Preview" />
        <p id="image-preview-text">Long press the image and tap "Save to Photos"</p>
    </div>
</div>

<script>
    function setButtonLoading(button, isLoading, loadingText = "Submitting...") {
        if (isLoading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = `<span class="spinner" style="margin-right: 8px;"></span>${loadingText}`;
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('sidebar-modal');
        const modalBody = document.getElementById('modal-body');
        const closeBtn = document.getElementById('close-sidebar-modal');
        const accessType = '{{ $accessType ?? 'live' }}';

        document.querySelectorAll('[data-mode]').forEach(item => {
            if (item.getAttribute('data-mode') !== accessType) {
                item.style.display = 'none';
            }
        });

        const openModal = (contentHTML) => {
            modalBody.innerHTML = contentHTML;
            modal.style.display = 'flex';
        };

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            modalBody.innerHTML = '';
        });

        document.getElementById('receive-pictures')?.addEventListener('click', e => {
            e.preventDefault();

            openModal(`
        <h3><i class="fa fa-envelope mr-2"></i> Receive all my pictures</h3>
        <p>Enter your email to receive your album link after your visit.</p>
        <input type="email" id="email-input" placeholder="you@example.com" style="width:100%; padding:10px;" />
        <button id="submit-email" style="margin-top:10px; background-color:#1FAD9F; color:white; padding:10px 20px; border:none; border-radius:4px;">Submit</button>
    `);

            setTimeout(() => {
                document.getElementById('submit-email').addEventListener('click', () => {

                    const email = document.getElementById('email-input').value.trim();
                    const albumId = document.body.dataset.albumId;
                    const button = document.getElementById('submit-email');
                    setButtonLoading(button, true);

                    if (!email) {
                        toastr.error("Please enter a valid email.");
                        return;
                    }

                    fetch('/photographer/receive-link', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                album_id: albumId,
                                email
                            })
                        })
                        .then(async (res) => {
                            const text = await res.text();
                            try {
                                const data = JSON.parse(
                                    text);

                                if (res.ok && data.success) {
                                    modal.style.display = 'none';
                                    toastr.success(
                                        `You’ll receive your album link at ${email} after your visit.`
                                    );
                                } else {
                                    toastr.error(data.message ||
                                        "Something went wrong. Please try again."
                                    );
                                }
                            } catch (err) {
                                console.error("Invalid JSON response:", text);
                                toastr.error("Unexpected server response.");
                            }
                        })
                        .catch(err => {
                            console.error("Fetch failed:", err);
                            toastr.error("Server error. Please try again later.");
                        });
                });
            }, 0);
        });


        document.getElementById('invite-friend-qr')?.addEventListener('click', async e => {
            e.preventDefault();
            const albumId = {{ $album->id ?? 'null' }};
            if (!albumId) return alert('Missing album ID');
            try {
                const res = await fetch('/photographer/invite-qr', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        album_id: albumId
                    })
                });
                const data = await res.json();
                if (data.success) {
                    openModal(`
                    <h3><i class="fa fa-mobile mr-2"></i> Invite a friend to this album</h3>
                    <p>Scan this QR code to open the same live album on another phone.</p>
                    <img src="${data.qr_svg}" alt="QR Code" style="max-width:200px; margin: 1rem 0;" />
                    <p>This QR code works only while this album is alive. A new QR code replaces the one printed on the device.</p>
                `);
                } else {
                    alert('QR generation failed.');
                }
            } catch (err) {
                alert('Error generating QR.');
                console.error(err);
            }
        });

        document.getElementById('invite-friend-email')?.addEventListener('click', e => {
            e.preventDefault();

            openModal(`
        <h3><i class="fa fa-user-plus mr-2"></i> Invite a friend by Email</h3>
        <p>Enter your friend’s email to invite them to access this album.</p>
        <input type="email" id="friend-email" placeholder="friend@example.com" style="width:100%; padding:10px;" />
        <button id="submit-invite" style="margin-top:10px; background-color:#1FAD9F; color:white; padding:10px 20px; border:none; border-radius:4px;">Send Invitation</button>
    `);

            setTimeout(() => {
                document.getElementById('submit-invite').addEventListener('click', () => {
                    const email = document.getElementById('friend-email').value.trim();
                    const albumId = document.body.dataset.albumId;
                    const button = document.getElementById('submit-invite');
                    setButtonLoading(button, true);

                    if (!email) {
                        toastr.error("Please enter a valid email.");
                        return;
                    }

                    fetch('/photographer/invite-email', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                album_id: albumId,
                                friend_email: email
                            })
                        })
                        .then(async (res) => {
                            const text = await res.text();
                            try {
                                const data = JSON.parse(text);

                                if (res.ok && data.success) {
                                    modal.style.display = 'none';
                                    toastr.success(
                                        `Invitation sent to ${email}`);
                                } else {
                                    toastr.error(data.message ||
                                        "Something went wrong. Please try again."
                                    );
                                }
                            } catch (err) {
                                console.error("Invalid JSON response:", text);
                                toastr.error("Unexpected server response.");
                            }
                        })
                        .catch(err => {
                            console.error("Fetch failed:", err);
                            toastr.error("Server error. Please try again later.");
                        });
                });
            }, 0);
        });


        const imgModal = document.getElementById('image-preview-modal');
        const imgPreview = document.getElementById('preview-image');
        const closeImgModal = document.getElementById('close-image-preview');

        document.querySelectorAll('.image-preview-link').forEach(img => {
            img.addEventListener('click', function(e) {
                e.preventDefault();
                const image = this.querySelector('img');
                imgPreview.src = image.src;
                imgModal.style.display = 'flex';
            });
        });

        closeImgModal.addEventListener('click', () => {
            imgModal.style.display = 'none';
            imgPreview.src = '';
        });

        imgModal.addEventListener('click', (e) => {
            if (e.target === imgModal) {
                imgModal.style.display = 'none';
                imgPreview.src = '';
            }
        });
    });
</script>
