import Alpine from 'alpinejs';
import { gsap } from 'gsap';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // Entrada escalonada de tarjetas y bloques
    gsap.from('[data-animate="fade-up"]', {
        opacity: 0, y: 24, duration: 0.6, stagger: 0.08, ease: 'power2.out',
        clearProps: 'transform,opacity',
    });

    // Contadores numéricos
    document.querySelectorAll('[data-count]').forEach((el) => {
        const obj = { v: 0 };
        gsap.to(obj, {
            v: Number(el.dataset.count), duration: 1, ease: 'power1.out',
            onUpdate: () => (el.textContent = Math.round(obj.v)),
        });
    });

    // Barras de cupo
    document.querySelectorAll('[data-progress]').forEach((el) => {
        gsap.fromTo(el, { width: '0%' }, { width: el.dataset.progress + '%', duration: 1, ease: 'power2.out' });
    });

    // Balón que rebota
    const balon = document.querySelector('#balon');
    if (balon) {
        gsap.to(balon, { y: -28, duration: 0.5, repeat: -1, yoyo: true, ease: 'power1.out' });
    }
});
