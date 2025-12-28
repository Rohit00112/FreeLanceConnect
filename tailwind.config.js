import forms from '@tailwindcss/forms';

module.exports = {
    content: [
      './resources/**/*.{html,js,php}',
      './resources/views/**/*.blade.php',
    ],
    darkMode: "selector",
    theme: {
      extend: {
          container: {
              padding: '2rem',
              center: true
          },
      },
    },
    plugins: [forms,require('flowbite/plugin')]
  }
