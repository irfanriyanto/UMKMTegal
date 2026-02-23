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
                // Tema Coklat Craft Indonesia - Nuansa Batik & Kerajinan Tradisional
                craft: {
                    50: '#fdf8f3',
                    100: '#f9ede0',
                    200: '#f2d9c0',
                    300: '#e9be96',
                    400: '#de9c69',
                    500: '#d4804a',  // Primary - Coklat Terakota
                    600: '#c5683f',
                    700: '#a45236',
                    800: '#854432',
                    900: '#6c3a2b',
                    950: '#3a1c14',
                },
                batik: {
                    50: '#fefce8',
                    100: '#fef9c3',
                    200: '#fef08a',
                    300: '#fde047',
                    400: '#facc15',  // Kuning Emas Batik
                    500: '#eab308',
                    600: '#ca8a04',
                    700: '#a16207',
                    800: '#854d0e',
                    900: '#713f12',
                    950: '#422006',
                },
                kayu: {
                    50: '#faf5f0',
                    100: '#f3e8db',
                    200: '#e6cfb6',
                    300: '#d6b08a',
                    400: '#c48f5f',
                    500: '#b87743',  // Coklat Kayu Jati
                    600: '#a96238',
                    700: '#8c4d30',
                    800: '#72402c',
                    900: '#5e3626',
                    950: '#321a12',
                },
                tanah: {
                    50: '#f9f6f3',
                    100: '#f1ebe3',
                    200: '#e2d5c6',
                    300: '#cfb9a1',
                    400: '#ba987a',
                    500: '#ab8060',  // Coklat Tanah Liat
                    600: '#9e6f52',
                    700: '#835a45',
                    800: '#6b4a3c',
                    900: '#583f33',
                    950: '#2f201a',
                },
            },
        },
    },

    plugins: [forms],
};
