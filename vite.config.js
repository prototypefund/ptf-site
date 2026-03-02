import ViteRestart from "vite-plugin-restart";

const host = process.env.DDEV_HOSTNAME;

export default ({ command }) => ({
  base: command === "serve" ? "" : "/static/dist/",
  build: {
    manifest: "manifest.json",
    outDir: "web/static/dist/",
    rollupOptions: {
      input: {
        app: "src/js/main.js",
      },
    },
  },
  plugins: [
    ViteRestart({
      reload: ["templates/**/*"],
    }),
  ],
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    origin: `${host}:5173`,
    cors: {
      origin: /^https?:\/\/(?:[a-zA-Z0-9-]+\.)+ddev\.site(?::\d+)?$/,
    },
    allowedHosts: ['.ddev.site'],
  },
});
