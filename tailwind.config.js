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
                'hot-pink': {
                    50: '#fef1f8',
                    100: '#fde6f2',
                    200: '#fccee5',
                    300: '#faa5d0',
                    400: '#f76cb4',
                    500: '#f0479a',
                    600: '#e0287d',
                    700: '#c41964',
                    800: '#a31853',
                    900: '#881948',
                    950: '#530928',
                },
                'light-blue': {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
                'edubridge': {
                    'pink': '#FF1493',
                    'blue': '#87CEEB',
                    'pink-light': '#FF69B4',
                    'blue-light': '#ADD8E6',
                },
            },
        },
    },

    plugins: [forms],
};
