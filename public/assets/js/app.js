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

    document.addEventListener('DOMContentLoaded', function () {
        initAlertDismiss();
        initModals();
    });
})();
