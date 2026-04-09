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
        },
    },

    safelist: [
        'bg-pink-500', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-purple-500', 'bg-white',
        'text-pink-400', 'text-red-400', 'text-yellow-400', 'text-blue-400', 'text-purple-400',
        'border-pink-500', 'border-red-500', 'border-yellow-500', 'border-blue-500', 'border-purple-500',
        'ring-pink-500', 'ring-red-500', 'ring-yellow-500', 'ring-blue-500', 'ring-purple-500',
        'from-pink-500', 'from-red-500', 'from-yellow-500', 'from-blue-500', 'from-purple-500',
        'to-pink-600', 'to-red-600', 'to-yellow-600', 'to-blue-600', 'to-purple-600',
    ],

    plugins: [forms],
};
