export class PixelGrid extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const pixelGrid = this.querySelector("[data-pixel-grid]");
    const imageContainer = this.querySelector("[data-container]");

    if (!pixelGrid || !imageContainer) {
      return;
    }

    const imageContainerWidth = imageContainer.clientWidth;
    const imageContainerHeight = imageContainer.clientHeight;

    let pixelSurface = 900;
    let pixelSize = Math.sqrt(pixelSurface);
    let pixelPerRow = Math.floor(imageContainerWidth / pixelSize);
    let pixelPerColumn = Math.floor(imageContainerHeight / pixelSize);
    let totalPixel = pixelPerRow * pixelPerColumn;

    for (let i = 0; i < totalPixel; i++) {
      let newPixel = document.createElement("div");
      newPixel.classList.add("pixel");
      newPixel.style.width = `${pixelSize}px`;
      newPixel.style.height = `${pixelSize}px`;

      newPixel.addEventListener("mouseover", function () {
        let randomOpacityValue = Math.random();

        const pixelClasses = [
          "pixel-1",
          "pixel-2",
          "pixel-2",
          "pixel-2",
          "pixel-2",
          "pixel-2",
          "pixel-2",
          "pixel-3",
          "pixel-3",
          "pixel-3",
          "pixel-3",
          "pixel-4",
          "pixel-4",
          "pixel-4",
          "pixel-4",
          "pixel-4",
          "pixel-4",
        ];
        const randomClass =
          pixelClasses[Math.floor(Math.random() * pixelClasses.length)];

        newPixel.classList.remove("pixel-1", "pixel-2", "pixel-3", "pixel-4");
        newPixel.classList.add(randomClass);

        newPixel.animate([{ opacity: randomOpacityValue }, { opacity: 0 }], {
          duration: 300,
          easing: "ease-in-out",
        });
      });

      pixelGrid.appendChild(newPixel);
    }

    let cursorX = 0;
    let cursorY = 0;
    let idle = false;
    let idleTimeout;
    let idleAnimationInterval;

    window.addEventListener("mousemove", (e) => {
      const rect = imageContainer.getBoundingClientRect();
      cursorX = e.clientX - rect.left;
      cursorY = e.clientY - rect.top;

      idle = false;
      clearTimeout(idleTimeout);
      clearInterval(idleAnimationInterval);

      idleTimeout = setTimeout(() => {
        idle = true;
        startIdleAnimation();
      }, 0);
    });

    function startIdleAnimation() {
      if (!pixelGrid || !imageContainer) {
        return;
      }

      idleAnimationInterval = setInterval(() => {
        const pixels = pixelGrid.querySelectorAll(".pixel");
        const radius = 50;

        pixels.forEach((pixel) => {
          const rect = pixel.getBoundingClientRect();
          const containerRect = imageContainer.getBoundingClientRect();
          const pixelX = rect.left - containerRect.left + rect.width / 2;
          const pixelY = rect.top - containerRect.top + rect.height / 2;

          const distance = Math.hypot(pixelX - cursorX, pixelY - cursorY);

          if (distance < radius && Math.random() < 0.3) {
            const pixelClasses = [
              "pixel-1",
              "pixel-2",
              "pixel-2",
              "pixel-2",
              "pixel-2",
              "pixel-2",
              "pixel-2",
              "pixel-3",
              "pixel-3",
              "pixel-3",
              "pixel-3",
              "pixel-4",
              "pixel-4",
              "pixel-4",
              "pixel-4",
              "pixel-4",
              "pixel-4",
            ];
            const randomClass =
              pixelClasses[Math.floor(Math.random() * pixelClasses.length)];

            pixel.classList.remove("pixel-1", "pixel-2", "pixel-3", "pixel-4");
            pixel.classList.add(randomClass);

            let randomOpacityValue = Math.random();

            pixel.animate([{ opacity: randomOpacityValue }, { opacity: 0 }], {
              duration: 400,
              easing: "ease-in-out",
            });
          }
        });
      }, 50);
    }
  }
}
