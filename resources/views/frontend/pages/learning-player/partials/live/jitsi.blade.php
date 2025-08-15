<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' | ' . $setting?->app_name }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($setting?->favicon) }}">
    <style>
        html,
        body,
        #meet {
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="meet"></div>
    <!-- Jitsi Meet API script -->
    <script src="https://8x8.vc/libs/external_api.min.js"></script>
    <script type="text/javascript">
        let api;
        const initIframeAPI = () => {
            const domain = '8x8.vc'; // Jitsi Meet domain
            const options = {
                roomName: "{{ $roomName }}",
                parentNode: document.querySelector('#meet'),
                width: '100%',
                height: '100%',
                jwt: "{{ $jwt }}"
            };
            api = new JitsiMeetExternalAPI(domain, options);
        }
        window.onload = () => {
            initIframeAPI();
        }
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Disable specific key combinations (F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U)
        document.addEventListener('keydown', function(e) {
            if (e.keyCode === 123 || // F12
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || // Ctrl+Shift+I, Ctrl+Shift+J
                (e.ctrlKey && e.key === 'U')) { // Ctrl+U
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>
