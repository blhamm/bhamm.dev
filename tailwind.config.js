import tailwindConfig from 'tailwindcss';

const config = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      backgroundImage: {
        'custom-gradient': 'linear-gradient(45deg, #3498db, #e74c3c)', //add
      },
    },
  },
  plugins: [], //none yet
};

export default config;