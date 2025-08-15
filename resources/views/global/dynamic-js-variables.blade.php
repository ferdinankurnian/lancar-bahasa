{{-- Here will go all the strings that will be translated for javascript parts --}}
<script>
  var base_url = "{{ url('/') }}";
  var preloader_path = "{{ asset(Cache::get('setting')->preloader) }}";
  
  var demo_mode_error = "{{ __('This Is Demo Version. You Can Not Change Anything') }}";
  var translation_success = "{{ __('Translated Successfully!') }}";
  var translation_processing = "{{ __('Translation Processing, please wait...') }}";
  var search_instructor_placeholder = "{{ __('Search for an instructor with email or name') }}";
  var Previous = "{{ __('Previous') }}";
  var Next = "{{ __('Next') }}";
  var basic_error_message = "{{ __('Something went wrong') }}";
  var discount = "{{ __('Discount') }}";
  var subscribe_now = "{{ __('Subscribe Now') }}";
  var submitting = "{{ __('Submitting') }}...";
</script>