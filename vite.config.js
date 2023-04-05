import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/views/panel/layouts/ZedAdmin/src/css/app.css',
                'resources/views/panel/layouts/ZedAdmin/src/js/dashboard.js',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
