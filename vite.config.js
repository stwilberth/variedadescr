import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['swiper-container', 'swiper-slide'].includes(tag)
                }
            }
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', 'jquery', 'bootstrap']
                }
            }
        }
    }
}); 