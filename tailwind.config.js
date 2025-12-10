import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        // ⭐ IMPORTANTE → AGREGA ESTO:
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.css',   // <-- NECESARIO PARA QUE APP.CSS SE COMPILLE
    ],

    theme: {
        extend: {
            colors: {
                emerald: colors.emerald,
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
