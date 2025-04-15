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
  }
}
