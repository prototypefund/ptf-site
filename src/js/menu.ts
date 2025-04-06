export default function initMenu() {
  const header = document.querySelector("#js-header");
  const menu = document.querySelector("#js-menu-sandwich");

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

  const menus = header.querySelectorAll(".js-menu");

  menus.forEach((menu) => {
    const title = document.getElementById(`title-${menu.id}`);

    menu.addEventListener("mouseenter", () => {
      header
        .querySelectorAll(".active")
        .forEach((title) => title.classList.remove("active"));

      title?.classList.add("active");
    });

    menu.addEventListener("mouseleave", () => {
      title?.classList.remove("active");
    });
  });
}
