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
                sans: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#EE4D2D',
                neu: {
                    yellow:  '#FFE600',
                    blue:    '#0047FF',
                    red:     '#FF2D2D',
                    green:   '#00C853',
                    pink:    '#FF3F80',
                    orange:  '#FF6B00',
                    black:   '#0D0D0D',
                    white:   '#FAFAFA',
                    bg:      '#99C2FF',
                },
            },
            boxShadow: {
                'neu':    '4px 4px 0px 0px #0D0D0D',
                'neu-sm': '2px 2px 0px 0px #0D0D0D',
                'neu-lg': '6px 6px 0px 0px #0D0D0D',
                'neu-xl': '8px 8px 0px 0px #0D0D0D',
                'neu-pressed': '1px 1px 0px 0px #0D0D0D',
                'neu-blue':   '4px 4px 0px 0px #0047FF',
                'neu-yellow': '4px 4px 0px 0px #FFE600',
                'neu-red':    '4px 4px 0px 0px #FF2D2D',
            },
            borderWidth: {
                '3': '3px',
            },
        },
    },

    plugins: [forms],
};
