import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/js/main.js' , 'resources/sass/app.scss'],
            refresh: true,
        }),
    ],
    css:{
        preprocessorOptions:{
            scss:{
                additionalData: `@use "resources/sass/variables" as *;`
            }
        }
    },
   
});
