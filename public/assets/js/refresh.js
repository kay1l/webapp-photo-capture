document.addEventListener('DOMContentLoaded', () => {
    const photoContainer = document.getElementById('photo-container');
    const loader = document.getElementById('photo-loader');
    const threshold = 20;
    let startY = 0;
    let isPulling = false;
    let mouseStartY = 0;
    let isDragging = false;

    async function fetchNewPhotos() {
        if (!photoContainer || !loader) return;

        loader.style.display = 'block';

        try {
            const res = await fetch(photoContainer.dataset.fetchUrl);
            const newCaptures = await res.json();

            const existingIds = Array.from(photoContainer.querySelectorAll('.card[data-id]'))
                .map(card => card.getAttribute('data-id'));

            newCaptures.forEach(capture => {
                if (!existingIds.includes(String(capture.id))) {
                    const div = document.createElement('div');
                    div.className = 'card img-loaded image-preview-link';
                    div.setAttribute('data-id', capture.id);
                    div.innerHTML = `
                        <a href="#">
                            <img class="card-img-top probootstrap-animate fadeInUp probootstrap-animated"
                                 src="/storage/images/${capture.filename}"
                                 alt="Photo"
                                 data-full-src="/storage/images/${capture.filename}">
                        </a>
                    `;
                    photoContainer.prepend(div);
                }
            });
        } catch (err) {
            console.error('Error fetching new photos:', err);
        } finally {
            loader.style.display = 'none';
        }
    }

    // Auto refresh
    setInterval(fetchNewPhotos, 20000);
    window.addEventListener('focus', fetchNewPhotos);

    // Pull to refresh — touch
    document.addEventListener('touchstart', (e) => {
        if (window.scrollY === 0) {
            startY = e.touches[0].clientY;
            isPulling = true;
        }
    });

    document.addEventListener('touchmove', (e) => {
        if (!isPulling) return;
        const currentY = e.touches[0].clientY;
        const diffY = currentY - startY;

        if (diffY > threshold) {
            isPulling = false;
            fetchNewPhotos();
        }
    });

    document.addEventListener('touchend', () => {
        isPulling = false;
    });

    // Pull to refresh — mouse
    document.addEventListener('mousedown', (e) => {
        if (window.scrollY === 0) {
            mouseStartY = e.clientY;
            isDragging = true;
        }
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;

        const diff = e.clientY - mouseStartY;
        if (diff > threshold) {
            isDragging = false;
            fetchNewPhotos();
        }
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
    });
});
