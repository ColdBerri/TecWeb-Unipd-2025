document.addEventListener('DOMContentLoaded', function () {

    // --- Gestione Menu Hamburger ---
    const burgerButton = document.querySelector('.burger');
    const closeButton = document.querySelector('.exit');
    const menu = document.getElementById('mobile-menu');
    const overlay = document.querySelector('.overlayNascondi');

    if (burgerButton && menu && closeButton && overlay) {
        const focusableElementsInMenu = menu.querySelectorAll(
            'a[href], button:not([disabled])'
        );
        const firstFocusableElement = focusableElementsInMenu[0];
        const lastFocusableElement = focusableElementsInMenu[focusableElementsInMenu.length - 1];

        function openMenu() {
            burgerButton.setAttribute('aria-expanded', 'true');
            menu.hidden = false;
            overlay.classList.add('overlay');
            firstFocusableElement.focus();
            document.addEventListener('keydown', trapFocus);
        }

        function closeMenu() {
            burgerButton.setAttribute('aria-expanded', 'false');
            menu.hidden = true;
            overlay.classList.remove('overlay');
            burgerButton.focus();
            document.removeEventListener('keydown', trapFocus);
        }

        function trapFocus(event) {
            if (event.key === 'Escape') {
                closeMenu();
                return;
            }
            if (event.key === 'Tab') {
                if (event.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        event.preventDefault();
                        lastFocusableElement.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        event.preventDefault();
                        firstFocusableElement.focus();
                    }
                }
            }
        }

        burgerButton.addEventListener('click', openMenu);
        closeButton.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    }

    // --- Gestione Link "Vai al contenuto" ---
    const skipLink = document.querySelector('a.navicationHelp[href="#content"]');
    if (skipLink) {
        skipLink.addEventListener('click', function (event) {
            event.preventDefault();
            const mainContent = document.getElementById('content');
            if (mainContent) {
                const focusableSelector = 'a[href]:not([disabled]), button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled])';
                const firstFocusableElement = mainContent.querySelector(focusableSelector);
                if (firstFocusableElement) {
                    firstFocusableElement.focus();
                }
            }
        });
    }
});