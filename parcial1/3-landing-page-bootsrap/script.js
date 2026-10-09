document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menuToggle'); // Botón hamburguesa
    const sidebar = document.getElementById('sidebar');     // Barra lateral
    const backdrop = document.getElementById('sidebarBackdrop'); // Fondo oscuro inservible lol

    function openSidebar() {
        sidebar.classList.add('show');
        backdrop.classList.add('show');
        menuBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; 
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        backdrop.classList.remove('show');
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    function toggleSidebar() {
        if (sidebar.classList.contains('show')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    if (menuBtn && sidebar && backdrop) {
        menuBtn.addEventListener('click', toggleSidebar);
        backdrop.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });
    }

    // Slides en imagenes ya no funciona qpdo
    const slides = document.querySelectorAll('.hero-slider .slide');
    let currentSlide = 0;
    const slideIntervalTime = 5000;

    function nextSlide() {
        if (slides.length === 0) return;
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    if (slides.length > 1) {
        setInterval(nextSlide, slideIntervalTime);
    }

    // estado activo 
    const navLinks = document.querySelectorAll('#sidebar nav a');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(l => l.classList.remove('activa'));
            link.classList.add('activa');
            closeSidebar(); 
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
});