/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            width: {
                1000: "1000px",
                950: "950px",
                650: "650px",
            },
            height: {
                400: "400px",
            },
            backgroundColor: {
                "custom-gray": "#d8d8d8",
            },
            screens: {
                'tablet': '640px',
                'laptop': '1024px',
                'desktop': '1280px',
              },
        },
    },
    plugins: [],
};
