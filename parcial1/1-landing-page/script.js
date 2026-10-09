document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menuToggle'); // Menu desplegable
    const sidebar = document.getElementById('sidebar'); // Barra lateral
    const contentWrapper = document.querySelector('.content-wrapper');

    if (menuBtn && sidebar && contentWrapper) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            contentWrapper.classList.toggle('expanded');
        });
    }

    // Slides en imagenes
    const slides = document.querySelectorAll('.hero-slider .slide');
    let currentSlide = 0;
    const slideIntervalTime = 5000;

    function nextSlide() {
        if (slides.length === 0) return;
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    if(slides.length > 1) {
        setInterval(nextSlide, slideIntervalTime);
    }

    // estado activo dinamico
    const navLinks = document.querySelectorAll('#sidebar nav a')

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(l => l.classList.remove('activa'));
            link.classList.add('activa');
        });
    });

    const sections = document.querySelectorAll('section[id], footer[id]');

    const observerOptions = {
        root: null,
        rootMargin: '-20% 0px -70% 0px', 
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                const targetLink = document.querySelector(`#sidebar a[href="#${id}"]`);

                if (targetLink) {
                    navLinks.forEach(link => link.classList.remove('activa'));
                    targetLink.classList.add('activa');
                }
            }
        });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
})