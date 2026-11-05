import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                indigo: {
                    50: '#fbf1f3',
                    100: '#f5e1e5',
                    200: '#ebc6cd',
                    300: '#dca1ac',
                    400: '#c47384',
                    500: '#a8505f',
                    600: '#8B3A4A',
                    700: '#722f3d',
                    800: '#5a2530',
                    900: '#431b24',
                },
            },
        },
    },

    plugins: [forms],
};