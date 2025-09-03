<div class="modal fade" id="courseCompleteModal" tabindex="-1" aria-labelledby="courseCompleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseCompleteModalLabel">{{ __('Congratulations!') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('uploads/website-images/good-score.png') }}" alt="completed" class="img-fluid mb-3" style="max-width: 150px;">
                <h4 class="mb-3">{{ __('You have successfully completed the course!') }}</h4>

                <!-- Review Form -->
                <div class="review-form-container">
                    <p>{{ __('We would love to hear your feedback') }}</p>
                    <form id="courseReviewForm">
                        <div class="mb-3">
                            <div class="star-rating">
                                <i class="fas fa-star" data-rating="1"></i>
                                <i class="fas fa-star" data-rating="2"></i>
                                <i class="fas fa-star" data-rating="3"></i>
                                <i class="fas fa-star" data-rating="4"></i>
                                <i class="fas fa-star" data-rating="5"></i>
                                <input type="hidden" name="rating" id="ratingInput" value="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="review" class="form-control" rows="3" placeholder="{{ __('Write your review here...') }}"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Submit Review') }}</button>
                    </form>
                </div>

                <hr>

                <!-- Certificate Download -->
                <div class="certificate-download-container mt-3">
                    <p>{{ __('Download your certificate') }}</p>
                    <a href="" id="downloadCertificateBtn" class="btn btn-success">{{ __('Download Certificate') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.star-rating {
    font-size: 2rem;
    color: #d3d3d3;
    cursor: pointer;
}
.star-rating .fas.fa-star.selected, .star-rating .fas.fa-star:hover, .star-rating .fas.fa-star:hover ~ .fas.fa-star {
    color: #ffc107;
}
</style>
