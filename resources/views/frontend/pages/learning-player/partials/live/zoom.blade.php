<!DOCTYPE html>

<head>
    <title>{{ $lesson->title . ' | ' . $setting?->app_name }}</title>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($setting?->favicon) }}">
    <style type="text/css">
        .ax-outline-blue-important:first-child {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- Dependencies for client view and component view -->
    <script src="https://source.zoom.us/3.8.5/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.8.5/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.8.5/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.8.5/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.8.5/lib/vendor/lodash.min.js"></script>

    <!-- For Client View -->
    <script src="https://source.zoom.us/zoom-meeting-3.8.5.min.js"></script>
    <script>
        "use strict";
        var mn = "{{ $lesson->live->meeting_id }}";
        var user_name = "{{ userAuth()->name }}";
        var pwd = "{{ $lesson->live->password }}";
        var role = "{{ userAuth()->role }}" == 'student' ? 0 : 1; //1 is host and 0 is general user
        var email = "{{ userAuth()->email }}";
        var lang = "en-US";
        var china = 0;
        var sdkKey = "{{ $lesson->course->instructor->zoom_credential->client_id }}"; //SDK Key or Client ID
        var sdkSecret = "{{ $lesson->course->instructor->zoom_credential->client_secret }}"; //SDK Secret or Client Secret
        var leaveUrl = "{{ route('student.learning.index', $lesson->course->slug) }}";

        //Generate signature here
        ZoomMtg.generateSDKSignature({
            meetingNumber: mn,
            sdkKey: sdkKey,
            sdkSecret: sdkSecret,
            role: role,
            success: function(signature) {
                //After generating the signature, initializing the meeting
                ZoomMtg.preLoadWasm();
                ZoomMtg.prepareWebSDK();
                ZoomMtg.i18n.load(lang);
                ZoomMtg.init({
                    leaveUrl: leaveUrl,
                    disableCORP: !window.crossOriginIsolated, // default true
                    success: function() {
                        //Join to the meeting
                        ZoomMtg.join({
                            meetingNumber: mn,
                            userName: user_name,
                            signature: signature,
                            sdkKey: sdkKey,
                            userEmail: email,
                            passWord: pwd,
                            success: function(res) {
                                ZoomMtg.getAttendeeslist({});
                                ZoomMtg.getCurrentUser({
                                    success: function(res) {},
                                });
                            },
                            error: function(res) {},
                        });
                    },
                    error: function(res) {},
                });

                ZoomMtg.inMeetingServiceListener("onUserJoin", function(data) {});

                ZoomMtg.inMeetingServiceListener("onUserLeave", function(data) {});

                ZoomMtg.inMeetingServiceListener("onUserIsInWaitingRoom", function(data) {});

                ZoomMtg.inMeetingServiceListener("onMeetingStatus", function(data) {});
            },
        });

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
