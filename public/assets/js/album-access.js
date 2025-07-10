
  // Laravel-injected access type: 'live' or 'longterm'
  const accessType = '{{ $accessType ?? "live" }}';

  document.addEventListener('DOMContentLoaded', () => {
    // Toggle visibility of menu items
    document.querySelectorAll('[data-mode]').forEach(item => {
      if (item.getAttribute('data-mode') !== accessType) {
        item.style.display = 'none';
      } else {
        item.style.display = 'block';
      }
    });

    // Handle: Receive all my pictures (live)
    document.getElementById('receive-pictures')?.addEventListener('click', e => {
      e.preventDefault();
      const email = prompt("Enter your email to receive your album link later:");
      if (email) {
        // TODO: Send to backend
        alert(`You’ll receive a secure link at: ${email}`);
      }
    });

    // Handle: Invite friend via QR (live)
    document.getElementById('invite-friend-qr')?.addEventListener('click', e => {
      e.preventDefault();
      // TODO: Replace with real QR logic
      alert("QR Code displayed here. Let your friend scan it to open the album.");
    });

    // Handle: Invite friend via email (longterm)
    document.getElementById('invite-friend-email')?.addEventListener('click', e => {
      e.preventDefault();
      const friendEmail = prompt("Enter your friend's email to invite:");
      if (friendEmail) {
        // TODO: Send to backend
        alert(`Invitation sent to ${friendEmail}`);
      }
    });

    // Handle: Download ZIP (longterm)
    document.getElementById('download-zip')?.addEventListener('click', e => {
      e.preventDefault();
      // TODO: Trigger ZIP download
      alert("Starting ZIP download...");
    });
  });

