module.exports = {
    content: [
        "./resources/views/customer/includes/*.blade.php",
        "./resources/views/customer/*.blade.php",
        "./public/html/customer/*.html",
        "./public/html/admin/*.html",
        "./resources/js/customer/controller/app.js",
    ],
    theme: {
        groups: ["example"],
    },
    plugins: [require('tailwindcss-nested-groups')],
};
