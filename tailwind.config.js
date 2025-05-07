import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Inter', 'Helvetica', 'sans-serif','Figtree', ...defaultTheme.fontFamily.sans],
                sans: ['Inter', 'Helvetica', 'sans-serif'],
            },
            colors: {
                red: { 600: '#dc2626' },
                blue: { 600: '#2563eb' },
                green: { 600: '#16a34a' },
                
              }
        },
    },

    plugins: [forms],
};
