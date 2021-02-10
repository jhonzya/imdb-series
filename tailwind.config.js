const { colors } = require('tailwindcss/defaultTheme');

module.exports = {
    purge: false,
    theme: {
        fontFamily: {
            'fixed': ['"Fixedsys Excelsior 3.01"'],
        },
        colors: {
            blue: colors.blue,
            gray: colors.gray,
            green: colors.green,
            orange: colors.orange,
            pink: colors.pink,
            red: colors.red,
            transparent: colors.transparent,
            white: colors.white,
            yellow: colors.yellow,
        },
        extend: {
            gridTemplateColumns: {
                '13': 'repeat(13, minmax(0, 1fr))',
                '14': 'repeat(14, minmax(0, 1fr))',
                '15': 'repeat(15, minmax(0, 1fr))',
                '16': 'repeat(16, minmax(0, 1fr))',
                '17': 'repeat(17, minmax(0, 1fr))',
                '18': 'repeat(18, minmax(0, 1fr))',
                '19': 'repeat(19, minmax(0, 1fr))',
                '20': 'repeat(20, minmax(0, 1fr))',
                '21': 'repeat(21, minmax(0, 1fr))',
                '22': 'repeat(22, minmax(0, 1fr))',
                '23': 'repeat(23, minmax(0, 1fr))',
                '24': 'repeat(24, minmax(0, 1fr))',
                '25': 'repeat(25, minmax(0, 1fr))',
                '26': 'repeat(26, minmax(0, 1fr))',
                '27': 'repeat(27, minmax(0, 1fr))',
                '28': 'repeat(28, minmax(0, 1fr))',
                '29': 'repeat(29, minmax(0, 1fr))',
                '30': 'repeat(30, minmax(0, 1fr))',
                '31': 'repeat(31, minmax(0, 1fr))',
                '32': 'repeat(32, minmax(0, 1fr))',
            }
        },
    },
    variants: {},
    plugins: [],
}
