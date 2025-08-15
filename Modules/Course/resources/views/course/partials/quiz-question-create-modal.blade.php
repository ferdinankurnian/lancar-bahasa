<div class="modal-body">
    <form action="{{ route('admin.course-chapter.quiz-question.store', $quizId) }}" method="POST"
        class="add_lesson_form instructor__profile-form">
        @csrf

        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label for="title">{{ __('Question Title') }} <code>*</code></label>
                    <input id="title" name="title" type="text" value="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-grp">
                    <label for="title">{{ __('Grade') }} <code>*</code></label>
                    <input id="title" name="grade" type="text" value="" class="form-control">
                </div>
            </div>
        </div>

        <div>
            <button class="add-answer btn btn-primary" type="button">{{ __('Add Answer') }}</button>
        </div>

        <div class="answer-container">
            <div class="card border-1 mt-3">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-grp">
                            <div class="d-flex justify-content-between">
                                <label for="answer">{{ __('Answer Title') }} <code>*</code></label>
                                <button class="remove-answer" type="button"><i class="fas fa-trash-alt"></i></button>
                            </div>
                            <input class="answer form-control" name="answers[]" type="text" value="" required>
                        </div>
                        <div class="switcher d-flex mt-2">
                            <p class="mr-3">{{ __('Correct Answer') }}</p>
                            <label for="toggle-0">
                                <input type="checkbox" class="correct" id="toggle-0" value="1" name="correct[]" />
                                <span><small></small></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal-footer">
            <button type="submit" class="btn btn-primary submit-btn">{{ __('Create') }}</button>
        </div>
    </form>
</div>
