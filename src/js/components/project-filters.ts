export class ProjectFilters extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const filters = this.querySelector("[data-filters]");
    const filterToggle = this.querySelector("[data-filter-toggle]");
    const filterClose = this.querySelector("[data-filter-close]");

    if (!filters || !filterToggle || !filterClose) {
      return;
    }

    filterToggle.addEventListener("click", () => {
      const menuOpening = !filters.classList.contains("filter-open");
      menuOpening ? lockPageScroll() : unlockPageScroll();
      filters.classList.toggle("filter-open");
    });

    filterClose.addEventListener("click", () => {
      unlockPageScroll();
      filters.classList.remove("filter-open");
    });

    document.onkeydown = function (event) {
      if ("key" in event && (event.key === "Escape" || event.key === "Esc")) {
        filters.classList.remove("filter-open");
        unlockPageScroll();
      }
    };

    const lockPageScroll = () => {
      document.documentElement.classList.add("overflow-hidden");
    };

    const unlockPageScroll = () => {
      document.documentElement.classList.remove("overflow-hidden");
    };
  }
}
