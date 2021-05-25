module.exports = {
  purge: [
    './modules/**/Resources/views/*.blade.php',
    './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
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
  corePlugins: {
  //  backgroundOpacity: false,
  }
}
