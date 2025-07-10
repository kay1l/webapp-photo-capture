
  let startY = 0;
  let isPulling = false;
  const threshold = 20;

  const main = document.querySelector('.js-probootstrap-main');
  const loader = document.getElementById('photo-loader');

  // Touch start
  document.addEventListener('touchstart', (e) => {
    if (window.scrollY === 0) {
      startY = e.touches[0].clientY;
      isPulling = true;
    }
  });

  // Touch move
  document.addEventListener('touchmove', (e) => {
    if (!isPulling) return;

    const currentY = e.touches[0].clientY;
    const diffY = currentY - startY;

    if (diffY > threshold) {
      isPulling = false; // prevent multiple triggers
      fetchNewPhotos();
    }
  });

  // Reset on end
  document.addEventListener('touchend', () => {
    isPulling = false;
  });
  let mouseStartY = 0;
  let isDragging = false;

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

