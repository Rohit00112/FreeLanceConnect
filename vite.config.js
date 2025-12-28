import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     cors: {
    //         origin: 'http://freelance.test',
    //         methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    //         credentials: true
    //     }
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
