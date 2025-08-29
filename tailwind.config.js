import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import preset from './vendor/filament/filament/tailwind.config.preset'; // Tambahkan ini

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset], // Tambahkan ini
    content: [
        './app/Filament/**/*.php', // Tambahkan ini
        './resources/views/filament/**/*.blade.php', // Tambahkan ini
        './vendor/filament/**/*.blade.php', // Tambahkan ini
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};