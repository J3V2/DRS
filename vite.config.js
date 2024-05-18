import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/user.css",
                "resources/css/admin.css",
                "resources/js/app.js",
                "resources/js/user.js",
                "resources/js/admin.js",
                "resources/js/bootstrap.js",
            ],
            refresh: true,
        }),
    ],
});
