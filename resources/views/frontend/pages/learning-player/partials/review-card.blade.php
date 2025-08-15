@forelse ($reviews as $review)
<div class="review-part">
    <div class="course-review-head">
        <div class="review-author-thumb">
            <img src="{{ asset($review->user->image) }}" alt="img">
        </div>
        <div class="review-author-content">
            <div class="author-name">
                <h5 class="name">{{ $review->user->name }} <span>{{ formatDate($review->created_at) }}</span></h5>
                <div class="author-rating">
                    @for($i = 0; $i < $review->rating; $i++)
                    <i class="fas fa-star"></i>
                    @endfor
                </div>
            </div>
            {!! clean($review->review) !!}
        </div>
    </div>
</div>
@empty
{{-- <p class="text-center">{{ __('No reviews!') }}</p> --}}
@endforelse