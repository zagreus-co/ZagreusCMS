module.exports = {
  content: [
    './modules/**/Resources/views/**/*.blade.php',
    './modules/**/Resources/views/*.blade.php',
    './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
  ],
  theme: {
    extend: {
        spacing: {
            128: '32rem',
        },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
  corePlugins: {}
}
