export default defineConfig({
    plugins: [laravel({
        input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth.css', 'resources/js/auth.js'],
        refresh: true,
    })],
});
