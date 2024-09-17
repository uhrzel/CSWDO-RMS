import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    /* server: {
        host: "192.168.8.35" 
    }, */
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
