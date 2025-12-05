// =============== MENÚ HAMBURGUESA ===============
const hamburgerBtn = document.getElementById("hamburgerBtn");
const mobileMenu = document.getElementById("mobileMenu");

if (hamburgerBtn) {
    hamburgerBtn.addEventListener("click", () => {
        mobileMenu.style.display =
            mobileMenu.style.display === "block" ? "none" : "block";
    });
}

// =============== BOTÓN VOLVER ARRIBA ===============
const btnTop = document.getElementById("btnTop");

if (btnTop) {
    window.addEventListener("scroll", () => {
        if (window.scrollY > 150) {
            btnTop.style.display = "flex";
        } else {
            btnTop.style.display = "none";
        }
    });

    btnTop.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}

// =============== HERO SLIDER & PARTNERS SLIDER ===============
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Slider Principal
    const heroSliderEl = document.querySelector('.hero-slider');
    if (heroSliderEl) {
        new Swiper('.hero-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }

    // 2. Slider de Aliados (NUEVO)
    const partnersSliderEl = document.querySelector('.partners-slider');
    if (partnersSliderEl) {
        new Swiper('.partners-slider', {
            loop: true,
            slidesPerView: 2,
            spaceBetween: 30,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 50,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 60,
                },
            },
        });
    }
});

// ... (Tu código anterior del menú hamburguesa y botón top) ...

// =============== DROPDOWN REDES SOCIALES ===============
const socialBtn = document.getElementById("socialToggleBtn");
const socialDropdown = document.getElementById("socialDropdown");

if (socialBtn && socialDropdown) {
    
    // Toggle al hacer clic en el botón
    socialBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // Evita que el clic cierre inmediatamente
        socialDropdown.classList.toggle("show");
        socialBtn.classList.toggle("active");
    });

    // Cerrar si se hace clic fuera
    document.addEventListener("click", (e) => {
        if (!socialDropdown.contains(e.target) && !socialBtn.contains(e.target)) {
            socialDropdown.classList.remove("show");
            socialBtn.classList.remove("active");
        }
    });
}