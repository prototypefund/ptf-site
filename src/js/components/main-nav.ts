export class MainNav extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const header = this.querySelector("[data-header]");
    const menu = this.querySelector("[data-sandwich]");

    if (!header || !menu) {
      return;
    }

    menu.addEventListener("click", () => {
      const menuOpening = !header.classList.contains("menu-open");
      menuOpening ? lockPageScroll() : unlockPageScroll();
      header.classList.toggle("menu-open");
    });

    document.onkeydown = function (event) {
      if ("key" in event && (event.key === "Escape" || event.key === "Esc")) {
        header.classList.remove("menu-open");
        unlockPageScroll();
      }
    };

    const lockPageScroll = () => {
      document.documentElement.classList.add("overflow-hidden");
    };

    const unlockPageScroll = () => {
      document.documentElement.classList.remove("overflow-hidden");
    };

    header.querySelectorAll("[data-link-group]").forEach((linkGroup) => {
      if (!(linkGroup instanceof HTMLElement) || !linkGroup.dataset.linkGroup)
        return;

      const title = header.querySelector(
        `[data-title='${linkGroup.dataset.linkGroup}']`,
      );

      linkGroup.addEventListener("mouseenter", () => {
        header
          .querySelectorAll(".active")
          .forEach((title) => title.classList.remove("active"));

        title?.classList.add("active");
      });

      linkGroup.addEventListener("mouseleave", () => {
        title?.classList.remove("active");
      });
    });
  }
}
