/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");
module.exports = {
  content: ["./*.{html,php}"],
  darkMode: "class",
  theme: {
    container: {
      center: true,
      padding: "24px",
    },
    extend: {
      fontFamily: {
        "plus-jakarta": ["Plus Jakarta Sans", "sans-serif", ...defaultTheme.fontFamily.sans],
      },
      colors: {
        hitam: "#1D2026",
        abu: "#9D9FA2",
        putih: "#FAFBFF",
        "putih-gelap": "#F2F3F7",
        primary: "#03afb2",
      },
      screens: {
        "2xl": "1320px",
      },
      aspectRatio: {
        "4/3": "4 / 3",
      },
    },
  },
  plugins: [],
};
