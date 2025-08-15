@extends('frontend.layouts.master')
@section('meta_title', $seo_setting['contact_page']['seo_title'])
@section('meta_description', $seo_setting['contact_page']['seo_description'])
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('Contact Us')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => '', 'text' => __('Contact Us')]]" />
    <!-- breadcrumb-area-end -->
    <!-- contact-area -->
    <section class="contact-area section-py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-info-wrap">
                        <ul class="list-wrap">
                            @if($contact?->address)
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('frontend/img/icons/map.svg') }}" alt="img" class="injectable">
                                </div>
                                <div class="content">
                                    <h4 class="title">{{ __('Address') }}</h4>
                                    <p>{{ $contact?->address }}</p>
                                </div>
                            </li>
                            @endif
                            @if ($contact?->phone_one || $contact?->phone_two)
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('frontend/img/icons/contact_phone.svg') }}" alt="img"
                                        class="injectable">
                                </div>
                                <div class="content">
                                    <h4 class="title">{{ __('Phone') }}</h4>
                                    <a href="tel:{{ $contact?->phone_one }}">{{ $contact?->phone_one }}</a>
                                    <a href="tel:{{ $contact?->phone_two }}">{{ $contact?->phone_two }}</a>
                                </div>
                            </li>
                            @endif
                            @if($contact?->email_one || $contact?->email_two)
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('frontend/img/icons/emial.svg') }}" alt="img"
                                        class="injectable">
                                </div>
                                <div class="content">
                                    <h4 class="title">{{ __('E-mail Address') }}</h4>
                                    <a href="mailto:{{ $contact?->email_one }}">{{ $contact?->email_one }}</a>
                                    <a href="mailto:{{ $contact?->email_one }}">{{ $contact?->email_two }}</a>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="{{ ($contact?->address || $contact?->phone_one || $contact?->phone_two || $contact?->email_one || $contact?->email_two) ? 'col-lg-8' : 'col-lg-12' }}">
                    <div class="contact-form-wrap">
                        <h4 class="title">{{ __('Send Us Message') }}</h4>
                        <p>{{ __('Your email address will not be published. Required fields are marked') }} *</p>
                        <form id="contact-form" action="" method="POST">
                            @csrf
                            <div class="form-grp">
                                <textarea name="message" placeholder="{{ __('Comment') }} *" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-grp">
                                        <input name="subject" type="text" placeholder="{{ __('Subject') }} *" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <input name="name" type="text" placeholder="{{ __('Name') }} *" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <input name="email" type="email" placeholder="{{ __('E-mail') }} *" required>
                                    </div>
                                </div>
                                <!-- g-recaptcha -->
                                @if (Cache::get('setting')->recaptcha_status === 'active')
                                    <div class="form-grp mt-3">
                                        <div class="g-recaptcha"
                                            data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}"></div>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-two arrow-btn">{{ __('Submit Now') }}<img
                                    src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img"
                                    class="injectable"></button>
                        </form>
                        <p class="ajax-response mb-0"></p>
                    </div>
                </div>
            </div>
            <!-- contact-map -->
            @if($contact?->map)
            <div class="contact-map">
                <iframe src="{{ $contact?->map }}" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            @endif
            <!-- contact-map-end -->
        </div>
    </section>
    <!-- contact-area-end -->
@endsection

@if (session('contactUs') && $setting->google_tagmanager_status == 'active' && $marketing_setting?->contact_page)
    @php
        $contactUs = session('contactUs');
        session()->forget('contactUs');
    @endphp
    @push('scripts')
        <script>
            $(function() {
                dataLayer.push({
                    'event': 'contactUs',
                    'contact_info': @json($contactUs)
                });
            });
        </script>
    @endpush
@endif
