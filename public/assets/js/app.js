/* ==========================================================================
   SiteFueler — Main Script (app.js)
   --------------------------------------------------------------------------
   Vanilla JavaScript only. No jQuery, no frameworks.
   One file for now; we'll split it later if it grows large.
   ========================================================================== */

(function () {
    'use strict';

    /* ----------------------------------------------------------------------
       Dismissible alerts
       Event-delegated: any [data-dismiss="alert"] removes its .alert parent
       with a 200ms fade (instant if reduced-motion is preferred).
       ---------------------------------------------------------------------- */
    function initAlertDismiss() {
        document.addEventListener('click', function (event) {
            var trigger = event.target.closest('[data-dismiss="alert"]');
            if (!trigger) return;

            var alert = trigger.closest('.alert');
            if (!alert) return;

            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (reduceMotion) {
                alert.remove();
                return;
            }

            alert.classList.add('is-dismissing');
            alert.addEventListener('transitionend', function handler() {
                alert.removeEventListener('transitionend', handler);
                alert.remove();
            });
        });
    }

    /* ----------------------------------------------------------------------
       Modals (native <dialog>)
       - [data-modal-open="id"] opens the dialog#id
       - [data-modal-close] closes the containing dialog
       - backdrop click closes, unless [data-no-backdrop-close]
       - native <dialog> handles Escape, focus trap, and background inertness
       - body scroll is locked while any modal is open
       ---------------------------------------------------------------------- */
    function prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function openModal(dialog) {
        if (!dialog || typeof dialog.showModal !== 'function') return;
        dialog.showModal();
        document.body.classList.add('modal-open');
        requestAnimationFrame(function () {
            dialog.classList.add('is-open');
        });
    }

    function closeModal(dialog) {
        if (!dialog) return;
        var finish = function () {
            dialog.close();
            document.body.classList.remove('modal-open');
        };
        dialog.classList.remove('is-open');
        if (prefersReducedMotion()) {
            finish();
            return;
        }
        var done = false;
        var onEnd = function () {
            if (done) return;
            done = true;
            dialog.removeEventListener('transitionend', onEnd);
            finish();
        };
        dialog.addEventListener('transitionend', onEnd);
        setTimeout(onEnd, 250); // fallback if transitionend doesn't fire
    }

    function initModals() {
        document.addEventListener('click', function (event) {
            var opener = event.target.closest('[data-modal-open]');
            if (opener) {
                var dialog = document.getElementById(opener.getAttribute('data-modal-open'));
                if (dialog) {
                    event.preventDefault();
                    openModal(dialog);
                }
                return;
            }
            var closer = event.target.closest('[data-modal-close]');
            if (closer) {
                var dlg = closer.closest('dialog.modal');
                if (dlg) {
                    event.preventDefault();
                    closeModal(dlg);
                }
            }
        });

        document.querySelectorAll('dialog.modal').forEach(function (dialog) {
            // Backdrop click (a click on the dialog itself, not its inner panel)
            dialog.addEventListener('click', function (event) {
                if (dialog.hasAttribute('data-no-backdrop-close')) return;
                if (event.target === dialog) {
                    closeModal(dialog);
                }
            });
            // Escape: animate close + unlock scroll instead of native instant close
            dialog.addEventListener('cancel', function (event) {
                event.preventDefault();
                closeModal(dialog);
            });
        });
    }

    /* ----------------------------------------------------------------------
       Header off-canvas drawer (mobile)
       [data-nav-open] opens #site-mobile-nav; [data-nav-close] (X / backdrop)
       closes it. Escape closes; background scroll is locked while open.
       ---------------------------------------------------------------------- */
    function initHeaderNav() {
        var opener = document.querySelector('[data-nav-open]');
        var drawer = document.getElementById('site-mobile-nav');
        if (!opener || !drawer) return;

        var panel = drawer.querySelector('.nav-drawer__panel');
        var closeBtn = drawer.querySelector('[data-nav-close].nav-drawer__close, .nav-drawer__close');

        function openDrawer() {
            drawer.classList.add('is-open');
            document.body.classList.add('nav-open');
            opener.setAttribute('aria-expanded', 'true');
            if (closeBtn) closeBtn.focus();
        }
        function closeDrawer() {
            drawer.classList.remove('is-open');
            document.body.classList.remove('nav-open');
            opener.setAttribute('aria-expanded', 'false');
            opener.focus();
        }

        opener.addEventListener('click', openDrawer);

        drawer.addEventListener('click', function (event) {
            if (event.target.closest('[data-nav-close]')) {
                closeDrawer();
            }
            // Close after following a nav link
            if (event.target.closest('.nav-drawer__nav a')) {
                drawer.classList.remove('is-open');
                document.body.classList.remove('nav-open');
                opener.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && drawer.classList.contains('is-open')) {
                closeDrawer();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initAlertDismiss();
        initModals();
        initHeaderNav();
    });
})();
