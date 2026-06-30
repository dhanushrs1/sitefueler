/* ==========================================================================
   SiteFueler — Admin Script (admin.js)
   Sidebar off-canvas toggle + topbar dropdowns. Vanilla JS.
   ========================================================================== */

(function () {
    'use strict';

    /* Sidebar (mobile off-canvas) */
    function initSidebar() {
        var opener = document.querySelector('[data-admin-nav-open]');
        var backdrop = document.querySelector('[data-admin-nav-close]');
        if (!opener) return;

        function open() {
            document.body.classList.add('admin-nav-open');
            opener.setAttribute('aria-expanded', 'true');
        }
        function close() {
            document.body.classList.remove('admin-nav-open');
            opener.setAttribute('aria-expanded', 'false');
        }

        opener.addEventListener('click', open);
        if (backdrop) backdrop.addEventListener('click', close);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') close();
        });
    }

    /* Topbar dropdowns (notifications, profile) */
    function initDropdowns() {
        var dropdowns = Array.prototype.slice.call(document.querySelectorAll('[data-dropdown]'));

        function closeAll(except) {
            dropdowns.forEach(function (d) {
                if (d === except) return;
                d.classList.remove('is-open');
                var t = d.querySelector('[data-dropdown-toggle]');
                if (t) t.setAttribute('aria-expanded', 'false');
            });
        }

        dropdowns.forEach(function (dropdown) {
            var toggle = dropdown.querySelector('[data-dropdown-toggle]');
            if (!toggle) return;
            toggle.addEventListener('click', function (e) {
                e.stopPropagation();
                var willOpen = !dropdown.classList.contains('is-open');
                closeAll(dropdown);
                dropdown.classList.toggle('is-open', willOpen);
                toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });
        });

        document.addEventListener('click', function () { closeAll(null); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeAll(null);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSidebar();
        initDropdowns();
    });
})();
