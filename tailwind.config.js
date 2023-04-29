/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./'],
  purge: ['./'],
  mode: 'jit',
  theme: {
    extend: {
      fontFamily: {
        primary: 'Playfair Display',
        secondary: 'Poppins',
      },
      animation: {
        marquee: 'marquee 25s linear infinite',
        marquee2: 'marquee2 25s linear infinite',
      },
      keyframes: {
        marquee: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-100%)' },
        },
        marquee2: {
          '0%': { transform: 'translateX(100%)' },
          '100%': { transform: 'translateX(0%)' },
        },
      },
    },
  },
  plugins: [],
};
