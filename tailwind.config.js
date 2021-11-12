const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
            'main-site': "url('/images/main-site-image.jpg')",
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            textAlign: ["first", "last"],
            outline: ["focus-visible"],
            margin: ["first", "last"],
            padding: ["first", "last"],
            borderRadius: ["first", "last"],
            borderWidth: ["first", "last"],
            textDecoration: ["first", "last"],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
