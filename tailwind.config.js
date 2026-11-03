import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                angkut: {
                    dark: '#537B2F',     // Palette 1
                    medium: '#8DA750',   // Palette 2
                    light: '#E4EB9C',    // Palette 3
                    deep: '#1E3011',     // Deep stroke/outline
                    pop: '#FFBF00',      // Playful yellow
                    orange: '#FF772A',   // Playful vibrant orange
                    cream: '#FAFDE8',    // Tinted cream
                    soft: '#F4F7E6',     // Soft tint
                },
            },
            borderWidth: {
                '3': '3px',
                '4': '4px',
                '5': '5px',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Figtree', ...defaultTheme.fontFamily.sans],
                fun: ['"Fredoka"', '"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'cartoon-xs': '2px 2px 0px #1E3011',
                'cartoon-sm': '3px 3px 0px #1E3011',
                'cartoon': '4px 4px 0px #1E3011',
                'cartoon-md': '5px 5px 0px #1E3011',
                'cartoon-lg': '6px 6px 0px #1E3011',
                'cartoon-xl': '8px 8px 0px #1E3011',
                'cartoon-pop': '4px 4px 0px #C97D00',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                    '50%': { transform: 'translateY(-10px) rotate(2deg)' },
                },
                'float-reverse': {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                    '50%': { transform: 'translateY(10px) rotate(-2deg)' },
                },
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-3deg)' },
                    '50%': { transform: 'rotate(3deg)' },
                },
                donutSpin: {
                    '0%': { transform: 'rotate(0deg)' },
                    '100%': { transform: 'rotate(360deg)' },
                }
            },
            animation: {
                float: 'float 4s ease-in-out infinite',
                'float-slow': 'float 6s ease-in-out infinite',
                'float-reverse': 'float-reverse 5s ease-in-out infinite',
                wiggle: 'wiggle 2s ease-in-out infinite',
                'donut-spin': 'donutSpin 16s linear infinite',
            }
        },
    },

    plugins: [forms],
};
