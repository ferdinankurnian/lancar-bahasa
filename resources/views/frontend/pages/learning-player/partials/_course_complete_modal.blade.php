<div class="modal fade" id="courseCompleteModal" tabindex="-1" aria-labelledby="courseCompleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseCompleteModalLabel">{{ __('Congratulations!') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="congratsMessage">
                    <img src="{{ asset('uploads/website-images/good-score.png') }}" alt="completed" class="img-fluid mb-3" style="max-width: 150px;">
                    <h4 class="mb-3">{{ __('You have successfully completed the course!') }}</h4>
                </div>

                {{-- Check if the user has already reviewed this course --}}
                @if(!isset($hasReviewed) || !$hasReviewed)
                    <!-- Review Container -->
                    <div class="review-container">
                        <!-- Step 1: Rating -->
                        <div class="review-step" id="ratingStep">
                            <p class="rating-prompt">{{ __('We would love to hear your feedback') }}</p>
                            <div class="star-rating">
                                <i class="fas fa-star" data-rating="1"></i>
                                <i class="fas fa-star" data-rating="2"></i>
                                <i class="fas fa-star" data-rating="3"></i>
                                <i class="fas fa-star" data-rating="4"></i>
                                <i class="fas fa-star" data-rating="5"></i>
                            </div>
                        </div>

                        <!-- Step 2: Review Form -->
                        <div class="review-step" id="reviewStep" style="display: none;">
                            <form id="courseReviewForm">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="rating" id="ratingInput" value="0">
                                <div class="mb-3">
                                    <textarea name="review" class="form-control" placeholder="{{ __('Write your review here...') }}" style="height: 120px;"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Submit Review') }}</button>
                            </form>
                        </div>

                        <!-- Step 3: Thank You -->
                        <div class="review-step" id="thankYouStep" style="display: none;">
                            <h4 class="my-4">{{ __('Thank you for your review!') }}</h4>
                            <p>{{ __('You will be redirected shortly.') }}</p>
                        </div>
                    </div>

                    <hr id="reviewSeparator">
                @endif

                <!-- Action Buttons -->
                <div id="actionButtons">
                    <div class="my-3">
                        <p>{{ __('What\'s next?') }}</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="" id="downloadCertificateBtn" class="btn btn-success">{{ __('Download Certificate') }}</a>
                            <a href="{{ route('student.enrolled-courses') }}" class="btn btn-primary">{{ __('Back to My Courses') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Existing styles for stars */
    .star-rating {
        font-size: 2rem;
        color: #d3d3d3;
        cursor: pointer;
        display: flex;
        justify-content: center;
        gap: 15px;
        transition: color 0.3s ease;
        padding: 10px 0 20px;
    }
    .star-rating .fas.fa-star {
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .star-rating .fas.fa-star.selected,
    .star-rating:hover .fas.fa-star:hover {
        color: #ffc107;
        transform: scale(1.15);
    }
    .star-rating:hover .fas.fa-star:hover ~ .fas.fa-star {
        color: #d3d3d3;
        transform: scale(1);
    }
    .star-rating .fas.fa-star.selected {
        transform: scale(1.1);
    }

    /* New styles for fade-in effect */
    #reviewStep, #thankYouStep {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confetti logic
        var courseCompleteModal = document.getElementById('courseCompleteModal');
        if (courseCompleteModal) {
            courseCompleteModal.addEventListener('shown.bs.modal', function () {
                confetti({ zIndex: 9999 });
            });
        }

        // Download button logic
        const downloadBtn = document.getElementById('downloadCertificateBtn');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                const button = this;
                
                // Change text and disable to prevent multiple clicks
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
                button.classList.add('disabled');

                // We assume the download starts and finishes.
                // After a delay, we update the text.
                setTimeout(function() {
                    button.innerHTML = 'Downloaded';
                }, 4000); // 4-second delay for feedback
            }, { once: true }); // The listener will only run once
        }

        // Review flow logic (only if review container exists)
        const reviewContainer = document.querySelector('.review-container');
        if (reviewContainer) {
            const stars = document.querySelectorAll('.star-rating .fas.fa-star');
            const ratingInput = document.getElementById('ratingInput');
            const ratingStep = document.getElementById('ratingStep');
            const reviewStep = document.getElementById('reviewStep');
            const thankYouStep = document.getElementById('thankYouStep');
            const actionButtons = document.getElementById('actionButtons');
            const reviewForm = document.getElementById('courseReviewForm');
            const reviewSeparator = document.getElementById('reviewSeparator');
            const ratingPrompt = document.querySelector('.rating-prompt');

            let ratingClicked = false;

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    ratingClicked = true;

                    // Highlight all stars up to the clicked one
                    stars.forEach((s, i) => {
                        s.classList.toggle('selected', i < rating);
                    });

                    if (ratingPrompt) ratingPrompt.style.display = 'none';
                    if (actionButtons) actionButtons.style.display = 'none';
                    if (reviewSeparator) reviewSeparator.style.display = 'none';
                    
                    reviewStep.style.display = 'block';
                });

                star.addEventListener('mouseover', function() {
                    if (ratingClicked) return;
                    const rating = this.getAttribute('data-rating');
                    stars.forEach((s, i) => {
                        s.classList.toggle('selected', i < rating);
                    });
                });
            });

            const starRating = document.querySelector('.star-rating');
            if(starRating) {
                starRating.addEventListener('mouseleave', function() {
                    if (ratingClicked) return;
                    const currentRating = ratingInput.value;
                    stars.forEach((s, i) => {
                        s.classList.toggle('selected', i < currentRating);
                    });
                });
            }

            if(reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitButton = this.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.textContent = 'Submitting...';

                    const formData = new FormData(this);
                    
                    fetch("{{ route('student.add-review') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json();
                        } else {
                            // If not JSON, but the request was successful (2xx status),
                            // we can assume it succeeded on the backend.
                            return { success: true };
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            const congratsMessage = document.getElementById('congratsMessage');
                            if (congratsMessage) {
                                congratsMessage.style.display = 'none';
                            }

                            ratingStep.style.display = 'none';
                            reviewStep.style.display = 'none';
                            thankYouStep.style.display = 'block';

                            setTimeout(() => {
                                window.location.href = "{{ route('student.enrolled-courses') }}";
                            }, 2500);
                        } else {
                            alert(data.message || 'An error occurred. Please try again.');
                            submitButton.disabled = false;
                            submitButton.textContent = 'Submit Review';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please check the console and try again.');
                        submitButton.disabled = false;
                        submitButton.textContent = 'Submit Review';
                    });
                });
            }
        }
    });
</script>