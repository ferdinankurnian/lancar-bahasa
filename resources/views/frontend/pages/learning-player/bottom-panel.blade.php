<div class="video_tabs_area">
    <ul class="nav nav-pills" id="pills-tab2" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                type="button" role="tab" aria-controls="pills-home"
                aria-selected="true">{{ __('Overview') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                type="button" role="tab" aria-controls="pills-profile"
                aria-selected="false">{{ __('Q&A') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                type="button" role="tab" aria-controls="pills-contact"
                aria-selected="false">{{ __('Announcements') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#pills-disabled"
                type="button" role="tab" aria-controls="pills-disabled"
                aria-selected="false">{{ __('Reviews') }}</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
            tabindex="0">
            <div class="video_about">
                <h1>{{ __('About this Lecture') }}</h1>
                <div class="about-lecture">{{ __('No description') }}</div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
            tabindex="0">
            <div class="video_qna">

                <div class="qna_list_area">
                    <div class="video_qna_top d-flex flex-wrap">
                        <form action="#" class="query-form">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <ul class="d-flex flex-wrap">
                            <li>

                            </li>
                            <li>
                                <p>{{ __('Filters') }}:</p>
                                <div class="select_box">
                                    <select class="filter-type">
                                        <option selected value="current_lecture">{{ __('Current lecture') }}</option>
                                        <option value="all_lectures">{{ __('All lectures') }}</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="video_qna_list">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <h3>{{ __('All questions') }}.</h3>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                {{ __('Ask a Question') }}
                            </button>
                        </div>
                        <div class="question-list">

                            <div class="text-center pt-3 pb-3">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">{{ __('Loading') }}...</span>
                                </div>
                            </div>

                        </div>

                        <div class="text-center p-5">
                            <form action="#" class="load-more-form">
                                <button type="submit" class="btn load-more-btn">{{ __('Load More') }}</button>
                            </form>
                        </div>

                    </div>
                </div>

                <div class="qna_details_area d-none">

                    <a href="#" class="btn arrow-btn back_qna_list mt-4">{{ __('Back to All Questions') }}</a>

                    <div class="reply-holder">
                        <div class="text-center pt-3 pb-3">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">{{ __('Loading') }}...</span>
                            </div>
                        </div>
                    </div>

                    <div class="qna_details_reply">
                        <form action="#" class="replay-form" method="POST">
                            @csrf
                            <textarea name="reply" placeholder="Add reply" class="text-editor-img"></textarea>
                            <!-- g-recaptcha -->
                            @if (Cache::get('setting')->recaptcha_status === 'active')
                                <div class="form-grp mt-3">
                                    <div class="g-recaptcha"
                                        data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}">
                                    </div>
                                </div>
                            @endif
                            <button type="submit" class="btn arrow-btn replay-btn mt-3">{{ __('submit') }}</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
            tabindex="0">
            @forelse($announcements as $announcement)
                <div class="video_about">
                    <div class="announcement_item">
                        <span>{{ formatDate($announcement->created_at) }}</span>
                        <h1>{{ $announcement->title }}</h1>
                        {!! clean($announcement->announcement) !!}
                    </div>
                </div>
                <div class="border border-1"></div>
            @empty
                <p class="text-center mt-2">{{ __('No announcement available') }}</p>
            @endforelse
        </div>
        <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab"
            tabindex="0">
            <div class="video_review">
                <h2>{{ __('Reviews') }}</h2>
                <div class="review-holder"></div>

                <div class="text-center mt-3">
                    <form action="" class="load-more-rating" method="GET">
                        <button class="btn btn-primary" type="submit">{{ __('Load More') }}</button>
                    </form>
                </div>

                <div class="video_review_imput mt-2">
                    <h2 class="mb-2">{{ __('Write a review') }}</h2>

                    <form action="{{ route('student.add-review') }}" class="instructor__profile-form"
                        method="POST">
                        @csrf
                        <input type="hidden" value="{{ $course->id }}" name="course_id">
                        <div class="col-md-12">
                            <div class="form-grp">
                                <label for="">{{ __('Rating') }}</label>
                                <select name="rating" id="" required>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-grp">
                                <label for="phone">{{ __('Review') }} <code>*</code></label>
                                <textarea name="review" class="form-control" required></textarea>
                            </div>
                        </div>
                        <!-- g-recaptcha -->
                        @if (Cache::get('setting')->recaptcha_status === 'active')
                            <div class="form-grp mt-3">
                                <div class="g-recaptcha"
                                    data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}">
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn arrow-btn">{{ __('Submit') }}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ask a Question') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="instructor__profile-form qna-form" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="form-grp">
                        <label for="total_mark">{{ __('Question') }} <code>*</code></label>
                        <input id="total_mark" name="question" type="text" value="">
                    </div>
                    <div class="form-grp">
                        <label for="total_mark">{{ __('Description') }} <code>*</code></label>
                        <textarea class="text-editor-img" name="description"></textarea>
                    </div>

                    <!-- g-recaptcha -->
                    @if (Cache::get('setting')->recaptcha_status === 'active')
                        <div class="form-grp mt-3">
                            <div class="g-recaptcha" data-sitekey="{{ Cache::get('setting')->recaptcha_site_key }}">
                            </div>
                        </div>
                    @endif
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
