import "@splidejs/splide/css/core";

export class GalleryCarousel extends HTMLElement {
  constructor() {
    super();
  }

  async connectedCallback() {
    const { default: Splide } = await import("@splidejs/splide");

    const instance = new Splide(this.querySelector(".splide"), {
      arrows: false,
      pagination: false,
      padding: "calc(var(--spacing) * 5)",
      gap: 24,
      autoWidth: true,
      drag: "free",
      snap: false,
      easingFunc: (t) => 1 - Math.pow(1 - t, 5),
      breakpoints: {
        767: {
          padding: "calc(var(--spacing) * 2)",
          gap: 16,
        },
      },
    });

    instance.mount();
  }
}
