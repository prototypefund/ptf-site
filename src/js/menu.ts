export default function initMenu() {
  const header = document.querySelector("#js-header");

  if (!header) {
    return;
  }

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
