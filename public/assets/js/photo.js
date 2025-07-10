function fetchNewPhotos() {
    const loader = document.getElementById('photo-loader');
    const container = document.querySelector('.card-columns');

    if (!loader || !container) return Promise.resolve();

    loader.style.display = 'block';

    return new Promise((resolve) => {
      console.log("Fetching new photos...");

      setTimeout(() => {
        const newCard = document.createElement('div');
        newCard.className = 'card img-loaded';
        newCard.innerHTML = `
          <a href="#">
            <img class="card-img-top probootstrap-animate" src="images/new_img.jpg" alt="New image">
          </a>`;
        container.prepend(newCard); // Add at top

        loader.style.display = 'none';
        resolve();
      }, 1000);
    });
  }
