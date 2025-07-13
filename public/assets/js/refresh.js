document.addEventListener("DOMContentLoaded", () => {
    const photoContainer = document.getElementById("photo-container");
    const loader = document.getElementById("photo-loader");
    const refreshBtn = document.getElementById("manual-refresh-btn");
    let lastCaptureIds = new Set();
    let isPulling = false;
    let startY = 0;
    const threshold = 50;

    // Helper: Load existing image filenames
    document.querySelectorAll(".card img").forEach((img) => {
        const filename = img.src.split("/").pop();
        lastCaptureIds.add(filename);
    });

    // Helper: Fetch new images via AJAX
    function fetchNewPhotos() {
        loader.style.display = "block";
        const albumId = document.body.dataset.albumId;
        const userId = document.body.dataset.userId;
        const hash = document.body.dataset.hash;
        const url = `/album/${albumId}/${userId}/${hash}/captures`;
        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.text())
            .then((html) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");
                const newCards = doc.querySelectorAll(".card.img-loaded");

                let newCount = 0;
                newCards.forEach((card) => {
                    const img = card.querySelector("img");
                    const filename = img.src.split("/").pop();

                    if (!lastCaptureIds.has(filename)) {
                        lastCaptureIds.add(filename);
                        photoContainer.insertBefore(
                            card,
                            photoContainer.firstChild
                        );
                        newCount++;
                    }
                });

                if (newCount > 0)
                    console.log(`Appended ${newCount} new photo(s).`);
            })
            .catch(console.error)
            .finally(() => {
                loader.style.display = "none";
            });
    }

    // Refresh every 20 seconds
    setInterval(fetchNewPhotos, 20000);

    // Refresh on tab focus
    document.addEventListener("visibilitychange", () => {
        if (document.visibilityState === "visible") {
            fetchNewPhotos();
        }
    });

    // Refresh on window focus
    window.addEventListener("focus", fetchNewPhotos);

    // Manual refresh button
    refreshBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        fetchNewPhotos();
    });

    // Pull-to-refresh gesture (touch)
    document.addEventListener("touchstart", (e) => {
        if (window.scrollY === 0) {
            startY = e.touches[0].clientY;
            isPulling = true;
        }
    });

    document.addEventListener("touchend", (e) => {
        if (isPulling) {
            const endY = e.changedTouches[0].clientY;
            if (endY - startY > threshold) {
                fetchNewPhotos();
            }
            isPulling = false;
        }
    });

    // Pull-to-refresh gesture (mouse)
    document.addEventListener("mousedown", (e) => {
        if (window.scrollY === 0) {
            startY = e.clientY;
            isPulling = true;
        }
    });

    document.addEventListener("mouseup", (e) => {
        if (isPulling) {
            const endY = e.clientY;
            if (endY - startY > threshold) {
                fetchNewPhotos();
            }
            isPulling = false;
        }
    });


});
