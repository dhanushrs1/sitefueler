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

    document.addEventListener('DOMContentLoaded', function () {
        initAlertDismiss();
    });
})();
