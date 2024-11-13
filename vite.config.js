import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/retro/bootstrap.css',
                'resources/js/retro/bootstrap.min.js'
            ],
            refresh: true,
        }),
    ],
});
