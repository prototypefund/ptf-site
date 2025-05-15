import "../css/main.css";
import { BarChartTest } from "./components/bar-chart";
import { DisplayToggle } from "./components/display-toggle";
import { MainNav } from "./components/main-nav";
import { TextAnimation } from "./components/text-animation";

if (
  !customElements.get("display-toggle") ||
  customElements.get("main-nav") ||
  customElements.get("bar-chart") ||
  customElements.get("text-animation")
) {
  customElements.define("display-toggle", DisplayToggle);
  customElements.define("main-nav", MainNav);
  customElements.define("bar-chart", BarChartTest);
  customElements.define("text-animation", TextAnimation);
}

window.addEventListener("beforeprint", () => {
  // we’re doing this to remove dark mode styles during printing
  document.documentElement.classList.add("print");
});

window.addEventListener("afterprint", () => {
  document.documentElement.classList.remove("print");
});

if (import.meta.hot) {
  import.meta.hot.accept();
}
