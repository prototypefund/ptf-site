export class MainNav extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const header = this.querySelector("[data-header]");
    const menu = this.querySelector("[data-sandwich]");
    const links = this.querySelector("[data-links]");
    const linkGroups = this.querySelector("[data-link-groups]");

    if (!header || !menu || !links || !linkGroups) {
      return;
    }

    menu.addEventListener("click", () => {
      const menuOpening = !header.classList.contains("menu-open");
      menuOpening ? lockPageScroll() : unlockPageScroll();
      header.classList.toggle("menu-open");
    });

    linkGroups.addEventListener("touchstart", (e) => {
      e.stopPropagation();
      links.classList.toggle("group-menu-open");
    });

    document.addEventListener("touchstart", (e) => {
      const target = e.target as HTMLElement;

      if (target && !links.contains(target)) {
        links.classList.remove("group-menu-open");
      }
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
  }
}
