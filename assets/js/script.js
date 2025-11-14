// Fichier: /recrutement-local/assets/js/script.js

document.addEventListener('DOMContentLoaded', () => {

    // --- Animations on scroll (IntersectionObserver) ---
    const animateOnScrollElements = document.querySelectorAll('.animate-fade-in-up, .animate-fade-in-left, .animate-fade-in-right, .animate-scale-in');

    const observerOptions = {
        root: null, // viewport
        rootMargin: '0px',
        threshold: 0.1 // 10% de l'élément doit être visible pour déclencher
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // Arrête d'observer une fois l'animation déclenchée
            }
        });
    }, observerOptions);

    animateOnScrollElements.forEach(el => {
        observer.observe(el);
    });

    // --- Styles initiaux pour les animations (à ajouter à votre style.css) ---
    // Les éléments cachés au départ
    // (Assurez-vous que ces styles sont bien dans votre style.css)
    // .animate-fade-in-up,
    // .animate-fade-in-left,
    // .animate-fade-in-right,
    // .animate-scale-in {
    //     opacity: 0;
    //     transform: translateY(20px);
    //     transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    // }

    // .animate-fade-in-up.is-visible {
    //     opacity: 1;
    //     transform: translateY(0);
    // }

    // .animate-fade-in-left {
    //     transform: translateX(-20px);
    // }
    // .animate-fade-in-left.is-visible {
    //     opacity: 1;
    //     transform: translateX(0);
    // }

    // .animate-fade-in-right {
    //     transform: translateX(20px);
    // }
    // .animate-fade-in-right.is-visible {
    //     opacity: 1;
    //     transform: translateX(0);
    // }

    // .animate-scale-in {
    //     transform: scale(0.9);
    // }
    // .animate-scale-in.is-visible {
    //     opacity: 1;
    //     transform: scale(1);
    // }

    // .delay-1 { transition-delay: 0.2s; }
    // .delay-2 { transition-delay: 0.4s; }
    // .delay-3 { transition-delay: 0.6s; }
    // .delay-4 { transition-delay: 0.8s; }

    // --- Hover effect for images (optional, if not in CSS) ---
    // .hover-grow {
    //     transition: transform 0.3s ease-in-out;
    // }
    // .hover-grow:hover {
    //     transform: scale(1.05);
    // }

    // --- Hero section overlay (from CSS) ---
    // .hero-section .overlay {
    //     position: absolute;
    //     top: 0;
    //     left: 0;
    //     width: 100%;
    //     height: 100%;
    //     background-color: rgba(0, 0, 0, 0.5); /* Couleur sombre avec transparence */
    //     z-index: 0; /* Assurez-vous qu'il est sous le contenu */
    // }
});