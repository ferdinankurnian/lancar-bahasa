"use strict"
const formButton = $(".qna-form button");
const questionMetaId = $("meta[name='question-id']");
const loader = `<div class="text-center pt-3 pb-3">
<div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
</div>
</div>`;

var page = 1;
var filter = "current_lecture";
var query = null;
var reviewPage = 1;
function fetchQuestions(course_id, lesson_id, page = 1, newLoad = false) {

    $.ajax({
        method: "get",
        url: base_url + "/student/fetch-lesson-questions",
        data: {
            course_id: course_id,
            lesson_id: lesson_id,
            page: page,
            filter: filter,
            query: query
        },
        beforeSend: function () {
            $(".load-more-form button").attr('disabled', true);
            $(".load-more-form button").text("Loading...");
            if(newLoad){
                $(".question-list").html(loader);
                // rest vars
                query = '';
                filter = 'current_lecture';
                $(".query-form input").val('');
            }

        },
        success: function (data) {
            if (data.page == 1) {
                $(".question-list").html(data.view);
            } else {
                $(".question-list").append(data.view);
            }

            $(".load-more-form button").attr('disabled', false);
            $(".load-more-form button").text("Load More");

            if(data.page == 1 && data.data_count == 0)  $(".question-list").html(data.view);
            if(data.data_count == 0) $(".load-more-form").addClass('d-none');
        },
        error: function (xhr, status, error) {
            $(".load-more-form button").attr('disabled', false);
            $(".load-more-form button").text("Load More");
        }
    })
}

function fetchReply(question_id) {

    $.ajax({
        method: "get",
        url: base_url + "/student/fetch-replies",
        data: {
            question_id: question_id
        },
        beforeSend: function () {
            $(".reply-holder").html(loader);
        },
        success: function (data) {
            $(".reply-holder").html(data);
        },
        error: function (xhr, status, error) {

        }
    })
}

function fetchReviews(courseId, reviewPage = 1) {

    $.ajax({
        method: "get",
        url: base_url + "/student/fetch-reviews/" + courseId,
        data: {
            page: reviewPage
        },
        beforeSend: function() {
            $(".load-more-rating button").attr('disabled', true);
            $(".load-more-rating button").text("Loading...");
        },
        success: function (data) {
            $(".review-holder").html(reviewPage == 1 ? data.view : $(".review-holder").html() + data.view);
            $(".load-more-rating").toggleClass('d-none', data.data_count == 0);
            if(data.page == 1 && data.data_count == 0)  $(".review-holder").html(data.view);

            $(".load-more-rating button").attr('disabled', false);
            $(".load-more-rating button").text("Load More");
        },
        error: function(xhr, status, error) {
            $(".load-more-rating button").attr('disabled', false);
            $(".load-more-rating button").text("Load More");
        }
    })
}



$(document).ready(function () {
    query = '';
    filter = 'current_lecture';
    $(".query-form input").val('');

    // fetch reviews
    let courseId = $("meta[name='course-id']").attr("content");
    fetchReviews(courseId);

    // show/hide question area
    $(document).on('click', '.question-item', function (e) {
        e.preventDefault();
        let questionId = $(this).attr('data-question-id');
        // set id to meta
        questionMetaId.attr('content', questionId);
        // fetch replies
        fetchReply(questionId);

        $('.qna_details_area').removeClass('d-none');
        $('.video_qna_list').addClass('d-none');
    })

    $(document).on('click', '.back_qna_list', function (e) {
        e.preventDefault();
        // reset id to meta
        questionMetaId.attr('content', '');

        $('.qna_details_area').addClass('d-none');
        $('.video_qna_list').removeClass('d-none');
    })


    $(".qna-form").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        formData += "&lesson_id=" + $("meta[name='lesson-id']").attr("content");

        $.ajax({
            method: "POST",
            url: base_url + "/student/create-question",
            data: formData,
            beforeSend: function () {
                formButton.attr("disabled", true);
                formButton.text("Loading...");
            },
            success: function (data) {
                fetchQuestions(data.question.course_id, data.question.lesson_id);

                formButton.attr("disabled", false);
                formButton.text("Submit");
                // hide the modal
                $("#exampleModal").modal("hide");

            },
            error: function (xhr, status, error) {
                formButton.attr("disabled", false);
                formButton.text("Submit");

                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    toastr.error(value);
                })
            }
        })
    })

    $(".replay-form").on("submit", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        formData += "&lesson_id=" + $("meta[name='lesson-id']").attr("content");
        formData += "&question_id=" + $("meta[name='question-id']").attr("content");

        $.ajax({
            method: "POST",
            url: base_url + "/student/create-reply",
            data: formData,
            beforeSend: function () {
                $(".replay-form .replay-btn").attr("disabled", true);
                $(".replay-form .replay-btn").text("Loading...");
            },
            success: function (data) {
                $(".replay-form .replay-btn").attr("disabled", false);
                $(".replay-form .replay-btn").text("Submit");
                $(".replay-form")[0].reset();
                toastr.success('Reply submitted successfully.');
                window.location.reload();
            },
            error: function (xhr, status, error) {
                $(".replay-form .replay-btn").attr("disabled", false);
                $(".replay-form .replay-btn").text("Submit");

                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    toastr.error(value);
                })
            }
        })
    })

    $(".load-more-form").on("submit", function (e) {
        e.preventDefault();
       
        let courseId = $("meta[name='course-id']").attr("content");
        let lessonId = $("meta[name='lesson-id']").attr("content");
        page = page + 1;
        fetchQuestions(courseId, lessonId, page);
    });

    $(".query-form").on('submit', function(e) {
        e.preventDefault();
        let queryVal = $(".query-form input").val();
        query = queryVal.trim();

        let courseId = $("meta[name='course-id']").attr("content");
        let lessonId = $("meta[name='lesson-id']").attr("content"); 
        page = 1;
        fetchQuestions(courseId, lessonId, page, true);
    });

    $(".filter-type").on('change', function() {
        let filterVal = $(this).val();
        filter = filterVal;

        let courseId = $("meta[name='course-id']").attr("content");
        let lessonId = $("meta[name='lesson-id']").attr("content"); 
        page = 1;
        fetchQuestions(courseId, lessonId, page);
    });

    // review pagination
    $(".load-more-rating").on("submit", function(e) {
        e.preventDefault();
        let courseId = $("meta[name='course-id']").attr("content");
        reviewPage = reviewPage + 1;
        fetchReviews(courseId, reviewPage);
    })

    /** Delete item */
    $(document).on("click", '.delete-item', function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "DELETE",
                    url: url,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    beforeSend: function () { },
                    success: function (data) {
                        if (data.status == "success") {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                            location.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error(error);
                    },
                });
            }
        });
    });
})
