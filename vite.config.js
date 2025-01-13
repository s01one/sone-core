import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                path.resolve(__dirname, 'src/resources/js/app.js'),
                path.resolve(__dirname, 'src/resources/sass/app.scss'),
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        outDir: path.resolve(__dirname, 'src/public/vendor/sone/core'),
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: [
                path.resolve(__dirname, 'src/resources/js/app.js'),
                path.resolve(__dirname, 'src/resources/sass/app.scss'),
            ],
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: ({ name }) => {
                    if (name.endsWith('.css')) return 'css/[name].css';
                    return 'assets/[name].[ext]';
                },
            },
        },
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'src/resources/js'),
            '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            'vue3-select': path.resolve(__dirname, 'node_modules/vue3-select'),
            'ziggy-js': path.resolve(__dirname, 'node_modules/ziggy-js'),
            '@sonecore-sass': path.resolve(__dirname, 'src/resources/sass'),
            '@sonecore-js': path.resolve(__dirname, 'src/resources/js'),
        },
        preserveSymlinks: true,
    },
    preserveSymlinks: true
});
