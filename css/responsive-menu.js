/**
 * Responsive Menu Toggle for SatanArise.com
 * Handles hamburger menu functionality on mobile devices
 */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileMenu);
    } else {
        initMobileMenu();
    }

    function initMobileMenu() {
        var menuToggle = document.getElementById('mobileMenuToggle');
        var menu = document.getElementById('menu');

        if (!menuToggle || !menu) {
            console.warn('Mobile menu elements not found');
            return;
        }

        // Toggle menu on button click
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMenu();
        });

        // Close menu when clicking menu items
        var menuLinks = menu.querySelectorAll('a');
        for (var i = 0; i < menuLinks.length; i++) {
            menuLinks[i].addEventListener('click', function() {
                // Close menu after a short delay to allow navigation
                setTimeout(function() {
                    closeMenu();
                }, 100);
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            var isClickInside = menuToggle.contains(e.target) || menu.contains(e.target);

            if (!isClickInside && menu.classList.contains('active')) {
                closeMenu();
            }
        });

        // Handle window resize
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Close menu on desktop breakpoint
                if (window.innerWidth >= 1024) {
                    closeMenu();
                }
            }, 250);
        });
    }

    function toggleMenu() {
        var menuToggle = document.getElementById('mobileMenuToggle');
        var menu = document.getElementById('menu');

        if (menu.classList.contains('active')) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    function openMenu() {
        var menuToggle = document.getElementById('mobileMenuToggle');
        var menu = document.getElementById('menu');

        menu.classList.add('active');
        menuToggle.classList.add('active');
        menuToggle.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        var menuToggle = document.getElementById('mobileMenuToggle');
        var menu = document.getElementById('menu');

        menu.classList.remove('active');
        menuToggle.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
    }
})();
