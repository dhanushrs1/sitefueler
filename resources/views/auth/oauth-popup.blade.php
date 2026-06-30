<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signing in…</title>
</head>
<body>
    <script>
        (function () {
            var payload = @json($payload);
            payload.type = 'sf-oauth';

            if (window.opener && !window.opener.closed) {
                window.opener.postMessage(payload, window.location.origin);
                window.close();
            } else {
                // No opener (popup blocked / direct hit) — navigate this window.
                window.location.replace(payload.redirect || '/');
            }
        })();
    </script>
    <noscript>
        <p>Continue to <a href="{{ $payload['redirect'] ?? '/' }}">SiteFueler</a>.</p>
    </noscript>
</body>
</html>
