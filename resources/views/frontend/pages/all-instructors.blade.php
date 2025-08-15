
@extends('frontend.layouts.master')
@section('meta_title', __('All Instructors') . ' || ' . $setting->app_name)
@section('contents')
    <!-- breadcrumb-area -->
    <x-frontend.breadcrumb :title="__('All Instructors')" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => '', 'text' => __('All Instructors')]]" />
    <!-- breadcrumb-area-end -->
    <!-- instructor-area -->
    <section class="instructor__area">
        <div class="container">
            <div class="row">
                @foreach($instructors as $instructor)
                @if($instructor->courses()->where(['status' => 'active', 'is_approved' => 'approved'])->count() > 0)
                <div class="col-xl-4 col-sm-6">
                    <div class="instructor__item">
                        <div class="instructor__thumb">
                            <a href="{{ route('instructor-details', ['id' => $instructor->id, 'slug' => Str::slug($instructor->name)]) }}"><img src="{{ asset($instructor->image) }}"
                                    alt="img"></a>
                        </div>
                        <div class="instructor__content">
                            <h2 class="title"><a href="{{ route('instructor-details', ['id' => $instructor->id, 'slug' => Str::slug($instructor->name)]) }}">{{ $instructor->name }}</a></h2>
                            <span class="designation">{{ $instructor->job_title }}</span>
                            <span>{{ $instructor->courses->count() }} {{ __('Courses') }}</span>
                            <p class="avg-rating">
                                <i class="fas fa-star"></i>
                                {{ number_format($instructor->courses->avg('avg_rating'), 1) }} {{ __('Ratings') }}
                            </p>
                            <div class="instructor__social">
                                <ul class="list-wrap">
                                    @if($instructor->facebook)
                                    <li><a href="{{ $instructor->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                  @endif
                                  @if($instructor->twitter)
                                    <li><a href="{{ $instructor->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                  @endif
                                  @if($instructor->linkedin)
                                    <li><a href="{{ $instructor->linkedin }}"><i class="fab fa-linkedin"></i></a></li>
                                  @endif
                                  @if($instructor->github)
                                    <li><a href="{{ $instructor->github }}"><i class="fab fa-github"></i></a></li>
                                  @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                <nav class="pagination__wrap mt-25">
                    {{ $instructors->links() }}
                </nav>
            </div>
        </div>
    </section>
    <!-- instructor-area-end -->
@endsection
