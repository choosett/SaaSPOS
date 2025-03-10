import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/auth.css',
                'resources/js/auth.js'
            ],
            refresh: true,  // Auto-reload on changes
        }),
    ],
    server: {
        host: 'localhost', // Adjust if running on a different local IP
        port: 5173, // Default Vite port, change if necessary
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,  // Fix for Docker/WSL/VMs not detecting changes
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js', // Allows imports like `@/components/MyComponent.vue`
        },
    },
    build: {
        chunkSizeWarningLimit: 600, // Avoid warnings for large files
        outDir: 'public/build', // Ensure Vite outputs correctly to Laravel's public assets
        manifest: true, // Required for production builds
        rollupOptions: {
            output: {
                manualChunks: undefined, // Allows better chunk optimization
            },
        },
    },
    optimizeDeps: {
        include: ['jquery'], // Ensure jQuery is optimized
    },
});
