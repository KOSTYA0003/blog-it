import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // 

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        port: 5176,
        origin: 'http://127.0.0.1:5176',
        cors: true,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },
});
