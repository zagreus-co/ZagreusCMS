module.exports = {
    content: [
      "./modules/**/Resources/views/**/*.blade.php",
      "./modules/**/Resources/views/*.blade.php",
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
            theme: {
                secondary: "#f8f9ff",
                primary: "#5c68ff",
                "darked-primary": "#4d56e0",
                gray: "#fafafa",
            },
        },
      },
    },
    variants: {
        extend: {},
    },
    plugins: [],
    corePlugins: {},
};
