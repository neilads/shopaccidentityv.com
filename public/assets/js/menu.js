document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const overlay = document.querySelector('.overlay');
    const closeButton = document.querySelector('.mobile-menu__close');

    // Toggle menu function
    function toggleMenu() {
        if (mobileMenu) {
            mobileMenu.classList.toggle('active');
        }
        if (overlay) {
            overlay.classList.toggle('active');
        }
        document.body.classList.toggle('no-scroll');
    }

    // Event listeners
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleMenu);
    }
    if (closeButton) {
        closeButton.addEventListener('click', toggleMenu);
    }
    if (overlay) {
        overlay.addEventListener('click', toggleMenu);
    }

    // Close menu on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('active')) {
            toggleMenu();
        }
    });
});