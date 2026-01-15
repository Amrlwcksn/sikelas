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
            colors: {
                primary: {
                    DEFAULT: '#0f172a',
                    accent: '#2563eb',
                    light: '#eff6ff',
                },
                secondary: '#64748b',
                success: '#10b981',
                danger: '#ef4444',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.25rem',
            },
        },
    },

    plugins: [forms],
};
