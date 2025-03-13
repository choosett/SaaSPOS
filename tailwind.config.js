import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/css/auth.css',
    ],

    safelist: [
        'left-4', 'left-64', 'fixed', 'top-4', 'z-50',
        'bg-[#0F317D]', 'p-2', 'transition-all', 'duration-500', 'ease-in-out'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', 'sans-serif'],  // ✅ Add Inter for table headers
                roboto: ['Roboto', 'sans-serif'], // ✅ Add Roboto for table data
            },
        },
    },

    plugins: [forms],
};
