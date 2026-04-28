/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./assets/vue/**/*.vue",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            colors: {
                surface: {
                    DEFAULT: '#ffffff',
                    muted: '#fafafa',
                    subtle: '#f4f4f5',
                },
                ink: {
                    DEFAULT: '#18181b',
                    muted: '#52525b',
                    soft: '#71717a',
                },
                edge: {
                    DEFAULT: '#e4e4e7',
                    strong: '#d4d4d8',
                },
                accent: {
                    DEFAULT: '#4f46e5',
                    hover: '#4338ca',
                    soft: '#eef2ff',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                display: ['Montserrat', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                card: '0 1px 2px 0 rgb(0 0 0 / 0.04), 0 1px 3px 0 rgb(0 0 0 / 0.06)',
                'card-hover': '0 8px 20px -4px rgb(0 0 0 / 0.08), 0 4px 8px -4px rgb(0 0 0 / 0.04)',
            },
        },
    },
    plugins: [],
}
