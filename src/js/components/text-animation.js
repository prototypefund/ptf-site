export class TextAnimation extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.animateText();
  }

  async animateText() {
    const lines = Array.from(this.querySelectorAll("p")).filter(
      (el) => el.textContent.trim() !== "",
    );

    for (const line of lines) {
      line.setAttribute("data-fulltext", line.textContent.trim());
      line.innerHTML = "";
    }

    for (const el of lines) {
      const text = el.getAttribute("data-fulltext") || "";
      await this.typeWriter(el, text, 50);
      el.classList.add("complete");
      await this.wait(100);
    }
  }

  async typeWriter(el, text, speed) {
    for (let i = 0; i <= text.length; i++) {
      el.innerHTML =
        text.substring(0, i) +
        '<span class="border-hot-pink border-r-[0.05em] [.complete_&]:border-r-0" aria-hidden="true"></span>';
      await this.wait(speed);
    }
  }

  wait(ms) {
    return new Promise((resolve) => setTimeout(resolve, ms));
  }
}
