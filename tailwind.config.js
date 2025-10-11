// tailwind.config.js
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography"; // <--- 1. TAMBAHKAN BARIS INI

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                enter: {
                    "0%": { transform: "translateY(20px)", opacity: "0" },
                    "100%": { transform: "translateY(0)", opacity: "1" },
                },
            },
            animation: {
                enter: "enter 0.5s ease-out forwards",
            },
        },
    },

    plugins: [forms, typography], // <--- 2. TAMBAHKAN 'typography' DI SINI
};