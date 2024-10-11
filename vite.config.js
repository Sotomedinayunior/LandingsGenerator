import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/js/main.js'],
            refresh: true,
        }),
    ],
    css:{
        preprocessorOptions:{
            scss:{
                additionalData: `@import "resources/sass/variables.scss";`
            }
        }
    }
});
