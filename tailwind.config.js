const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: ['./resources/**/*.blade.php'],
    darkMode: 'class', // or 'media' or 'class'
    theme: {
        fontFamily: {
            // https://ant.design/docs/spec/font#Font-Family
            sans: [
                '-apple-system',
                'BlinkMacSystemFont',
                'Segoe UI',
                'Roboto',
                'Helvetica Neue',
                'Arial',
                'Noto Sans',
                'sans-serif',
                'Apple Color Emoji',
                'Segoe UI Emoji',
                'Segoe UI Symbol',
                'Noto Color Emoji',
            ],
        },
        // https://ant.design/docs/spec/font#Font-Scale-&-Line-Height
        fontSize: {
            sm: ['12px', '20px'],
            base: ['14px', '22px'],
            lg: ['16px', '24px'],
            xl: ['20px', '28px'],
        },
        spacing: {
            ...defaultTheme.spacing,
            unit: defaultTheme.spacing['4'],
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            white: colors.white,
            black: colors.black,
            gray: colors.coolGray,
            green: colors.green,
            red: colors.red,
            blue: {
                50: '#e6f7ff',
                100: '#bae7ff',
                200: '#91d5ff',
                300: '#69c0ff',
                400: '#40a9ff',
                500: '#1890ff',
                600: '#096dd9',
                700: '#0050b3',
                800: '#003a8c',
                900: '#002766',
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
}
