<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/proper.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.odometer.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.appear.js') }}"></script>
<script src="{{ asset('frontend/js/tween-max.min.js') }}"></script>
<script src="{{ asset('frontend/js/select2.min.js') }}"></script>
<script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.marquee.min.js') }}"></script>
@if ($setting?->cursor_dot_status == 'active')
    <script src="{{ asset('frontend/js/tg-cursor.min.js') }}"></script>
@endif
<script src="{{ asset('frontend/js/svg-inject.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.circleType.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.lettering.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('frontend/js/plyr.min.js') }}"></script>
<script src="{{ asset('frontend/js/wow.min.js') }}"></script>
<script src="{{ asset('frontend/js/aos.js') }}"></script>
<script src="{{ asset('frontend/js/vivus.min.js') }}"></script>
<script src="{{ asset('global/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('frontend/js/sweetalert.js') }}"></script>
<script src="{{ asset('frontend/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('frontend/js/default/frontend.js') }}?v={{ $setting?->version }}"></script>
<script src="{{ asset('frontend/js/default/cart.js') }}?v={{ $setting?->version }}"></script>
<script src="{{ asset('global/nice-select/jquery.nice-select.min.js') }}"></script>
<!-- File Manager js-->
<script src="{{ url('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>


<script src="{{ asset('frontend/js/main.js') }}?v={{ $setting?->version }}"></script>

<script>
    $('.file-manager').filemanager('file', {
        prefix: '{{ url('/frontend-filemanager') }}'
    });
    $('.file-manager-image').filemanager('image', {
        prefix: '{{ url('/frontend-filemanager') }}'
    });

    SVGInject(document.querySelectorAll("img.injectable"));
</script>

<!-- dynamic Toastr Notification -->
<script>
    "use strict";
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;
    toastr.options.positionClass = 'toast-bottom-right';

    @session('messege')
    var type = "{{ Session::get('alert-type', 'info') }}"
    switch (type) {
        case 'info':
            toastr.info("{{ $value }}");
            break;
        case 'success':
            toastr.success("{{ $value }}");
            break;
        case 'warning':
            toastr.warning("{{ $value }}");
            break;
        case 'error':
            toastr.error("{{ $value }}");
            break;
    }
    @endsession

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        orientation: "bottom auto"
    });
</script>


<!-- Toastr -->
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}', null, {
                timeOut: 10000
            });
        </script>
    @endforeach
@endif


<!-- Google reCAPTCHA -->
@if (Cache::get('setting')->recaptcha_status === 'active')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif

<!-- tawk -->
@if ($setting->tawk_status == 'active')
    <script type="text/javascript">
        "use strict";
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = '{{ $setting->tawk_chat_link }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif

<!-- Cookie Consent -->
@if ($setting->cookie_status == 'active')
    <script src="{{ asset('frontend/js/cookieconsent.min.js') }}"></script>

    <script>
        "use strict";
        window.addEventListener("load", function() {
            window.wpcc.init({
                "border": "{{ $setting->border }}",
                "corners": "{{ $setting->corners }}",
                "colors": {
                    "popup": {
                        "background": "{{ $setting->background_color }}",
                        "text": "{{ $setting->text_color }} !important",
                        "border": "{{ $setting->border_color }}"
                    },
                    "button": {
                        "background": "{{ $setting->btn_bg_color }}",
                        "text": "{{ $setting->btn_text_color }}"
                    }
                },
                "content": {
                    "href": "{{ url($setting->link) }}",
                    "message": "{{ $setting->message }}",
                    "link": "{{ $setting->link_text }}",
                    "button": "{{ $setting->btn_text }}"
                }
            })
        });
    </script>
@endif

<script>
    if ($(".marquee_mode").length) {
        $('.marquee_mode').marquee({
            speed: 20,
            gap: 35,
            delayBeforeStart: 0,
            direction: "{{ Session::has('text_direction') && Session::get('text_direction') == 'rtl' ? 'right' : 'left' }}",
            duplicated: true,
            pauseOnHover: true,
            startVisible: true,
        });
    }
</script>

<script>
    $(document).on("click", '.wpcc-btn', function() {
        $('.wpcc-container').fadeOut(1000);
    });
</script>
