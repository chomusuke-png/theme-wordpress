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