const DESKTOP_QUERY = "(min-width: 768px)";

export class ProjectFilters extends HTMLElement {
  connectedCallback() {
    const filters = this.querySelector<HTMLElement>("[data-filters]");
    const form = this.querySelector<HTMLFormElement>("[data-filter-form]");
    const filterToggle = this.querySelector("[data-filter-toggle]");
    const filterClose = this.querySelector("[data-filter-close]");

    if (!filters || !form || !filterToggle || !filterClose) {
      return;
    }

    const desktop = window.matchMedia(DESKTOP_QUERY);

    const openFilters = () => {
      document.documentElement.classList.add("overflow-hidden");
      filters.classList.add("filter-open");
    };

    // Closing without applying discards unsubmitted changes.
    const closeFilters = () => {
      document.documentElement.classList.remove("overflow-hidden");
      filters.classList.remove("filter-open");
      form.reset();
    };

    // hide the submit button on desktop
    form.toggleAttribute("data-enhanced", true);

    form.addEventListener("change", () => {
      if (!desktop.matches) {
        return;
      }

      form.requestSubmit();
    });

    form.addEventListener("submit", (event) => {
      if (form.querySelector("input:checked")) {
        return;
      }

      event.preventDefault();
      window.location.assign(form.action);
    });

    this.querySelectorAll<HTMLButtonElement>("[data-filter-remove]").forEach(
      (button) => {
        button.addEventListener("click", () => {
          const input = document.getElementById(
            button.dataset.filterRemove ?? "",
          );

          if (!(input instanceof HTMLInputElement)) {
            return;
          }

          input.checked = false;
          form.requestSubmit();
        });
      },
    );

    filterToggle.addEventListener("click", () => {
      filters.classList.contains("filter-open")
        ? closeFilters()
        : openFilters();
    });

    filterClose.addEventListener("click", closeFilters);

    document.addEventListener("keydown", (event) => {
      if (
        event.key !== "Escape" ||
        !filters.classList.contains("filter-open")
      ) {
        return;
      }

      closeFilters();
    });
  }
}
