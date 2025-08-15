<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('backend/js/popper.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/stisla.js') }}"></script>
<script src="{{ asset('backend/js/scripts.js') }}?v={{$setting?->version}}"></script>
<script src="{{ asset('backend/js/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/tagify.js') }}"></script>
<script src="{{ asset('global/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('backend/js/fontawesome-iconpicker.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('backend/clockpicker/dist/bootstrap-clockpicker.js') }}"></script>
<script src="{{ asset('backend/datetimepicker/jquery.datetimepicker.js') }}"></script>
<script src="{{ asset('backend/js/iziToast.min.js') }}"></script>
<script src="{{ asset('backend/js/modules-toastr.js') }}?v={{$setting?->version}}"></script>
<script src="{{ asset('backend/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('global/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('backend/js/default/backend.js') }}?v={{$setting?->version}}"></script>
<script src="{{ asset('backend/js/custom.js') }}?v={{$setting?->version}}"></script>

<!-- File Manager js-->
<script src="{{ url('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

<script>
    $('.file-manager').filemanager('file', {prefix: '{{ url("/laravel-filemanager") }}'});
    $('.file-manager-image').filemanager('image', {prefix: '{{ url("/laravel-filemanager") }}'});
</script>

<script>
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

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
@endif
