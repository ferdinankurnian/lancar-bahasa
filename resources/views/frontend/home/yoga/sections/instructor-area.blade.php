<section class="instructor__area-five section-pt-140 section-pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section__title text-center mb-45">
                    <span class="sub-title">{{ __('Our Instructors') }}</span>
                    <h2 class="title">{!! clean(processText($featuredInstructorSection?->translation?->title)) !!}</h2>
                    <p>{!! clean(processText($featuredInstructorSection?->translation?->sub_title)) !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($selectedInstructors as $index => $instructor)
                @if ($index < 4)
                    <div class="col-lg-3 col-sm-6">
                        <div class="instructor__item-four">
                            <div class="instructor__thumb-four">
                                <a href="{{ route('instructor-details', $instructor->id) }}">
                                    <img src="{{ asset($instructor->image) }}" alt="img">
                                </a>
                            </div>
                            <div class="instructor__content-four">
                                <h2 class="title"><a
                                        href="{{ route('instructor-details', $instructor->id) }}">{{ $instructor->name }}</a>
                                </h2>
                                <span>{{ $instructor->job_title }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
