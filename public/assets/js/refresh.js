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

    // Full image preview on click
    document.querySelectorAll(".image-preview-link a").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const img = link.querySelector("img");
            const fullSrc = img.dataset.fullSrc;

            const modal = document.createElement("div");
            modal.style.position = "fixed";
            modal.style.top = 0;
            modal.style.left = 0;
            modal.style.width = "100%";
            modal.style.height = "100%";
            modal.style.backgroundColor = "rgba(0,0,0,0.8)";
            modal.style.display = "flex";
            modal.style.flexDirection = "column";
            modal.style.alignItems = "center";
            modal.style.justifyContent = "center";
            modal.style.zIndex = 9999;

            const fullImg = document.createElement("img");
            fullImg.src = fullSrc;
            fullImg.style.maxWidth = "90%";
            fullImg.style.maxHeight = "80vh";
            fullImg.style.marginBottom = "10px";

            const instruction = document.createElement("p");
            instruction.textContent =
                'Long press the image then tap "Save to Camera Roll"';
            instruction.style.color = "white";
            instruction.style.fontSize = "1rem";

            modal.appendChild(fullImg);
            modal.appendChild(instruction);

            modal.addEventListener("click", () => {
                document.body.removeChild(modal);
            });

            document.body.appendChild(modal);
        });
    });
});
