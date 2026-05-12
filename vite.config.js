import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    build: {
        chunkSizeWarningLimit: 1000,
    },
    resolve: {
        alias: {
            '@ts-menu': '/resources/js/packages/ts-menu',
            '@vue-admin': '/resources/js/packages/vue-admin',
            '@vue-media': '/resources/js/packages/vue-media',
            '@vue-theme': '/resources/js/packages/vue-theme',
            '@vue-user': '/resources/js/packages/vue-user',
            '@user': '/resources/js/packages/vue-user',
            '@media': '/resources/js/packages/vue-media',
            '@admin': '/resources/js/packages/vue-admin',
            '@theme': '/resources/js/packages/vue-theme',
            '@menu': '/resources/js/packages/ts-menu',
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
