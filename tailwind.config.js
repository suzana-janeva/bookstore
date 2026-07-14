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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand palette — indigo-violet accent from suzanajaneva.com
                brand: {
                    50: '#f2f0fb',
                    100: '#e5e1f6',
                    200: '#cfc7ee',
                    300: '#b1a4e2',
                    400: '#8b7fd4', // secondary / hover accent
                    500: '#6f5fc4',
                    600: '#5540af', // primary accent
                    700: '#4a389a',
                    800: '#3d2f7d',
                    900: '#332966',
                },
                ink: '#1A1A1A',   // near-black text
                canvas: '#FAFAFA', // page background
            },
            boxShadow: {
                card: '0 1px 3px rgba(26,26,26,0.06), 0 8px 24px rgba(26,26,26,0.05)',
                'card-hover': '0 4px 12px rgba(85,64,175,0.12), 0 12px 32px rgba(85,64,175,0.10)',
            },
        },
    },

    plugins: [forms],
};
