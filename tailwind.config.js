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
                slategray: '#393e43',
                darkslate: '#32383e',
                actionblue: '#0084dd',
                light: '#e9ecef',
                dark: '#272B30',
            },
            fontSize: {
                heading:  '1.640625rem'
            },
            
        },
    },

    plugins: [forms],
};
