/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js,php}", "./index.html"],
  theme: {
    extend: {
      colors: {
        primary : "#e2032f",
        secondary : "#192f59"
      }
    },
  },
  plugins: [],
}

