/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            // C'est ici qu'on définit tes couleurs personnalisées
            colors: {
                'party-yellow': '#FFBE0B',
                'party-orange': '#FB5607',
                'party-pink':   '#FF006E',
                'party-purple': '#8338EC',
                'party-blue':   '#3A86FF',
            },
            // On définit la police (optionnel, mais rend le site plus beau)
            fontFamily: {
                'sans': ['Outfit', 'ui-sans-serif', 'system-ui'], // Pour le texte
                'display': ['Fredoka', 'Outfit', 'ui-sans-serif'], // Pour les titres
            },
            // Si tu veux utiliser la classe "rounded-squircle" spécifiquement
            borderRadius: {
                'squircle': '32px', // Un arrondi très prononcé
            }
        },
    },
    plugins: [],
}
