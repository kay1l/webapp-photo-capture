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
</style>

<div id="sidebar-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-button" id="close-sidebar-modal">&times;</span>
        <div id="modal-body">
            <!-- Modal content will be injected here -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('sidebar-modal');
        const modalBody = document.getElementById('modal-body');
        const closeBtn = document.getElementById('close-sidebar-modal');

        const accessType = '{{ $accessType ?? 'live' }}'; // Blade/templating fallback

        // Filter based on data-mode
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

        // Event bindings
        document.getElementById('receive-pictures')?.addEventListener('click', e => {
            e.preventDefault();
            openModal(`
      <h3><i class="fa fa-envelope mr-2"></i> Receive all my pictures</h3>
      <p>Enter your email to receive your album link after your visit.</p>
      <input type="email" id="email-input" placeholder="you@example.com" style="width:100%; padding:10px;" />
      <button id="submit-email" style="margin-top:10px;">Submit</button>
    `);

            setTimeout(() => {
                document.getElementById('submit-email').addEventListener('click', () => {
                    const email = document.getElementById('email-input').value.trim();
                    if (email) {
                        alert(
                            `You’ll receive your album link at ${email} after your visit.`);
                        modal.style.display = 'none';
                    } else {
                        alert("Please enter a valid email.");
                    }
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
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
        <img src="${data.qr_image}" alt="QR Code" style="max-width:200px; margin: 1rem 0;" />
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
      <button id="submit-invite" style="margin-top:10px;">Send Invitation</button>
    `);

            setTimeout(() => {
                document.getElementById('submit-invite').addEventListener('click', () => {
                    const email = document.getElementById('friend-email').value.trim();
                    if (email) {
                        alert(`Invitation sent to ${email}`);
                        modal.style.display = 'none';
                    } else {
                        alert("Please enter a valid email.");
                    }
                });
            }, 0);
        });
    });
</script>
