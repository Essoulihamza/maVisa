/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/*.vue',
            './src/*/*.vue',
            './src/*/*/*.vue',
            './index.html',
          './node_modules/tw-elements/dist/js/**/*.js'],
  theme: {
    extend: {},
  },
  plugins: []
}
