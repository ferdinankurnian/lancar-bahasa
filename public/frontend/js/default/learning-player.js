"use strict";
const csrf_token = $("meta[name='csrf-token']").attr("content");

const placeholder = `<div class="player-placeholder">
<div class="preloader-two player">
    <div class="loader-icon-two player"><img src="${preloader_path}" alt="Preloader"></div>
</div>
</div>`;

function makeLessonComplete(lessonId, type, status) {
    $.ajax({
        method: "POST",
        url: base_url + "/student/learning/make-lesson-complete",
        data: {
            _token: csrf_token,
            lessonId: lessonId,
            status: status,
            type: type,
        },
        success: function (data) {
            if (data.status == "success") {
                toastr.success(data.message);
            } else if (data.status == "error") {
                toastr.error(data.message);
            }
        },
        error: function (xhr, status, error) {
            let errors = xhr.responseJSON.errors;
            $.each(errors, function (key, value) {
                toastr.error(value);
            });
        },
    });
}


function extractGoogleDriveVideoId(url) {
    // Regular expression to match Google Drive video URLs
    var googleDriveRegex =
        /(?:https?:\/\/)?(?:www\.)?(?:drive\.google\.com\/(?:uc\?id=|file\/d\/|open\?id=)|youtu\.be\/)([\w-]{25,})[?=&#]*/;

    // Try to match the URL with the regular expression
    var match = url.match(googleDriveRegex);

    // If a match is found, return the video ID
    if (match && match[1]) {
        return match[1];
    } else {
        return null;
    }
}

function showSidebar() {
    $(".wsus__course_sidebar").addClass("show");
}

function hideSidebar() {
    $(".wsus__course_sidebar").removeClass("show");
}

$(document).ready(function () {
    $(document).on('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
    $(document).on('keydown', function(e) {
        if (e.which === 123 ||
            (e.ctrlKey && e.shiftKey && (e.which === 'I'.charCodeAt(0) || e.which === 'J'.charCodeAt(0))) ||
            (e.ctrlKey && e.which === 'U'.charCodeAt(0))) {
            e.preventDefault();
            return false;
        }
    });

    //image popup init
    $(document).on("click", ".image-popup", function () {
        $.magnificPopup.open({
            items: {
                src: $(this).attr("src"),
            },
            type: "image",
        });
    });
    document.addEventListener("focusin", (e) => {
        if (
            e.target.closest(
                ".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root"
            ) !== null
        ) {
            e.stopImmediatePropagation();
        }
    });

    $(".form-check").on("click", function () {
        $(".form-check").removeClass("item-active");
        $(this).addClass("item-active");
    });

    $(".lesson-item").on("click", function () {
        // hide sidebar
        hideSidebar();

        var lessonId = $(this).attr("data-lesson-id");
        var chapterId = $(this).attr("data-chapter-id");
        var courseId = $(this).attr("data-course-id");
        var type = $(this).attr("data-type");

        $.ajax({
            method: "POST",
            url: base_url + "/student/learning/get-file-info",
            data: {
                _token: csrf_token,
                lessonId: lessonId,
                chapterId: chapterId,
                courseId: courseId,
                type: type,
            },
            beforeSend: function () {
                $(".video-payer").html(placeholder);
            },
            success: function (data) {
                // set lesson id on meta
                $("meta[name='lesson-id']").attr("content", data.file_info.id);
                let playerHtml;
                const { file_info } = data;

                if (file_info.file_type != 'video' && file_info.storage != 'iframe' && (file_info.type == 'lesson' || file_info.type == 'aws' || file_info.type == 'wasabi' || file_info.type == 'live')) {
                    if (file_info.storage == 'upload') {
                        playerHtml = `<div class="resource-file">
                        <div class="file-info">
                            <div class="text-center">
                                <img src="/uploads/website-images/resource-file.png" alt="">
                                <h6>${resource_text}</h6>
                                <p>${file_type_text}: ${file_info.file_type}</p>
                                <p>${download_des_text}</p>
                                <form action="/student/learning/resource-download/${file_info.id}" method="get" class="download-form">
                                    <button type="submit" class="btn btn-primary">${download_btn_text}</button>
                                </form>
                            </div>
                        </div>
                    </div>`
                    }else if(file_info.storage == 'live'){
                       let btnHtml = '';
                       if (file_info.is_live_now == 'started') {
                            btnHtml = `<h6>${le_hea}</h6>`;
                            btnHtml += `<p>${le_des} <b class="text-highlight">${file_info.end_time}</b></p>`;
                            if ((file_info.live.type === 'jitsi' && file_info.course.instructor.jitsi_credential) || (file_info.live.type === 'zoom' && file_info.course.instructor.zoom_credential)) {
                                btnHtml += `<a href="${base_url + '/student/learning/' + file_info.course.slug + '/' + file_info.id}" class="btn btn-two me-2">${open_w_txt}</a>`;
                            }else{
                                btnHtml += `<p>${file_info.live.type === 'zoom' ? 'Zoom' : 'Jitsi'} ${cre_mi_txt}</p>`;
                            }
                            if(file_info.live.type === 'zoom' && file_info.live.join_url){
                                btnHtml += `<a target="_blank" href="${file_info.live.join_url}" class="btn">Zoom app</a>`;
                            }
                        }else if(file_info.is_live_now == 'ended'){
                            btnHtml = `<h6>${le_fi_he}</h6>`;
                            btnHtml += `<p>${le_fi_des}</p>`;
                        } else {
                            btnHtml = `<h6>${le_wi_he}</h6>`;
                            btnHtml += `<p>${le_wi_des} <b class="text-highlight">${file_info.start_time}</b></p>`;
                        }

                        playerHtml = `<div class="resource-file">
                        <div class="file-info">
                            <div class="text-center">
                            <img src="${base_url + '/frontend/img/online-learning.png'}" alt="">
                                ${btnHtml}
                            </div>
                        </div>
                    </div>`
                    } else {
                        playerHtml = `<div class="resource-file">
                        <div class="file-info">
                            <div class="text-center">
                                <img src="/uploads/website-images/resource-file.png" alt="">
                                <h6>${resource_text}</h6>
                                <p>${file_type_text}: ${file_info.file_type}</p>
                                <p>${open_des_txt}</p>
                                <a href="${file_info.file_path}" target="_blank" class="btn btn-primary">${open_txt}</a>
                            </div>
                        </div>
                    </div>`
                    }
                } else if (file_info.storage == 'youtube' && (file_info.type == 'lesson' || file_info.type == 'live')) {
                    playerHtml = `<video id="vid1" class="video-js vjs-default-skin" controls autoplay width="640" height="264"
                        data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "${file_info.file_path}"}] }'>
                        </video>`;
                } else if (file_info.storage == 'vimeo' && (file_info.type == 'lesson' || file_info.type == 'live')) {
                    playerHtml = `<video id="vid1" class="video-js vjs-default-skin" controls autoplay width="640" height="264"
                        data-setup='{ "techOrder": ["vimeo"], "sources": [{ "type": "video/vimeo", "src": "${file_info.file_path}"}] }'>
                        </video>`;
                } else if ((file_info.storage == 'upload' || file_info.storage == 'external_link' || file_info.storage == 'aws' || file_info.storage == 'wasabi') && (file_info.type == 'lesson' || file_info.type == 'live')) {
                    playerHtml = `<video src="${file_info.file_path}" type="video/mp4" id="vid1" class="video-js vjs-default-skin" controls autoplay width="640" height="264"
                        data-setup='{}] }'>
                        </video>`;
                } else if (file_info.storage == 'google_drive' && file_info.type == 'lesson') {
                    playerHtml = `<iframe class="iframe-video" src="https://drive.google.com/file/d/${extractGoogleDriveVideoId(file_info.file_path)}/preview" width="640" height="680" allow="autoplay" frameborder="0" autoplay allowfullscreen></iframe>`
                } else if (file_info.type == 'document' && file_info.file_type != 'txt') {
                    playerHtml = data.view;
                } else if (file_info.storage == 'iframe' || file_info.type == 'document') {
                    playerHtml = `<iframe class="iframe-video" src="${file_info.type == 'document' ? base_url + file_info.file_path : file_info.file_path}" frameborder="0" allowfullscreen></iframe>`
                } else if (file_info.type == 'quiz') {
                    playerHtml = `<div class="resource-file">
                    <div class="file-info">
                        <div class="text-center">
                            <img src="/uploads/website-images/quiz.png" alt="">
                            <h6 class="mt-2">${file_info.title}</h6>
                            <p>${quiz_st_des_txt}</p>
                            <a href="/student/learning/quiz/${file_info.id}" class="btn btn-primary">${quiz_st_txt}</a>
                        </div>
                    </div>
                </div>`
                }

                // Resetting any existing player instance
                if (videojs.getPlayers()["vid1"]) {
                    videojs.getPlayers()["vid1"].dispose();
                }

                $(".video-payer").html(playerHtml);

                // Initializing the player
                if (document.getElementById("vid1")) {
                    let player = videojs("vid1");
                    let lessonCompleted = false;

                    player.ready(function () {
                        this.play();

                        this.on('timeupdate', function () {
                            let percentage = (this.currentTime() / this.duration()) * 100;
                            if (percentage >= 80 && !lessonCompleted) {
                                lessonCompleted = true;
                                let lessonId = $("meta[name='lesson-id']").attr("content");
                                let type = $('.lesson-item.active').attr('data-type');
                                makeLessonComplete(lessonId, type, 1);
                            }
                        });
                    });
                }

                // set lecture description
                $(".about-lecture").html(
                    file_info.description || no_des_txt
                );

                // load qna's
                fetchQuestions(courseId, lessonId, 1, true);

                // Update navigator state
                updateNavigator();

                // Add completion handler for documents
                if (type === 'document') {
                    const checkbox = $(".lesson-completed-checkbox[data-lesson-id='" + lessonId + "'][data-type='document']");
                    if (checkbox.length > 0 && !checkbox.is(':checked')) {
                        makeLessonComplete(lessonId, type, 1);
                    }
                }
            },
            error: function (xhr, status, error) { },
        });
    });

    $(".lesson-completed-checkbox").on("click", function (e) {
        e.preventDefault();
        return false;
    });

    // Course video button for small devices
    $(".wsus__course_header_btn").on("click", function () {
        $(".wsus__course_sidebar").addClass("show");
    });

    $(".wsus__course_sidebar_btn").on("click", function () {
        $(".wsus__course_sidebar").removeClass("show");
    });

    // Navigator functionality
    function updateNavigator() {
        const allLessons = $('.lesson-item');
        const activeLesson = $('.form-check.item-active .lesson-item');
        if (activeLesson.length === 0) return;

        const currentIndex = allLessons.index(activeLesson);
        const totalLessons = allLessons.length;
        const completedLessonsCount = $('.lesson-completed-checkbox:checked').length;

        // Previous button
        if (currentIndex === 0) {
            $('#prev-lesson-btn').css('visibility', 'hidden');
        } else {
            $('#prev-lesson-btn').css('visibility', 'visible');
        }

        // Next / Finish button
        if (currentIndex === totalLessons - 1) { // If on the last item
            if (completedLessonsCount === totalLessons) {
                $('#next-lesson-btn').html('Finish').show();
            } else {
                $('#next-lesson-btn').hide();
            }
        } else { // If not on the last item
            $('#next-lesson-btn').html('Next <i class="fas fa-angle-right"></i>').show();
        }
    }

    $('#next-lesson-btn').on('click', function(e) {
        e.preventDefault();
        const allLessons = $('.lesson-item');
        const activeLesson = $('.form-check.item-active .lesson-item');
        const currentIndex = allLessons.index(activeLesson);

        if (currentIndex < allLessons.length - 1) {
            allLessons.eq(currentIndex + 1).trigger('click');
        }
    });

    $('#prev-lesson-btn').on('click', function(e) {
        e.preventDefault();
        const allLessons = $('.lesson-item');
        const activeLesson = $('.form-check.item-active .lesson-item');
        const currentIndex = allLessons.index(activeLesson);

        if (currentIndex > 0) {
            allLessons.eq(currentIndex - 1).trigger('click');
        }
    });

    $('#prev-lesson-btn').on('click', function(e) {
        e.preventDefault();
        const allLessons = $('.lesson-item');
        const activeLesson = $('.form-check.item-active .lesson-item');
        const currentIndex = allLessons.index(activeLesson);

        if (currentIndex > 0) {
            allLessons.eq(currentIndex - 1).trigger('click');
        }
    });

    // Course Complete Modal & Review Logic
    $(document).on('click', '#next-lesson-btn', function(e) {
        e.preventDefault();
        if ($(this).text().trim() === 'Finish') {
            const courseId = $("meta[name='course-id']").attr("content");
            const certificateUrl = base_url + '/student/download-certificate/' + courseId;
            $('#downloadCertificateBtn').attr('href', certificateUrl).text('Download Certificate');
            
            var completeModal = new bootstrap.Modal(document.getElementById('courseCompleteModal'));
            completeModal.show();
        } else {
            // Regular next button functionality
            const allLessons = $('.lesson-item');
            const activeLesson = $('.form-check.item-active .lesson-item');
            const currentIndex = allLessons.index(activeLesson);

            if (currentIndex < allLessons.length - 1) {
                allLessons.eq(currentIndex + 1).trigger('click');
            }
        }
    });

    // Star rating interaction
    const stars = $('.star-rating .fa-star');
    stars.on('mouseover', function() {
        const rating = $(this).data('rating');
        stars.each(function(index) {
            if (index < rating) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
    });

    stars.on('mouseout', function() {
        const currentRating = $('#ratingInput').val();
        stars.each(function(index) {
            if (index < currentRating) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
    });

    stars.on('click', function() {
        const rating = $(this).data('rating');
        $('#ratingInput').val(rating);
        stars.each(function(index) {
            if (index < rating) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
    });

    // Review form submission
    $('#courseReviewForm').on('submit', function(e) {
        e.preventDefault();
        const courseId = $("meta[name='course-id']").attr("content");
        const rating = $('#ratingInput').val();
        const review = $(this).find('textarea[name="review"]').val();

        if (rating == 0) {
            toastr.error('Please select a rating');
            return;
        }

        $.ajax({
            method: "POST",
            url: base_url + "/student/add-review",
            data: {
                _token: csrf_token,
                course_id: courseId,
                rating: rating,
                review: review
            },
            beforeSend: function() {
                $(this).find('button[type="submit"]').prop('disabled', true).text('Submitting...');
            },
            success: function(data) {
                toastr.success('Review submitted successfully!');
                $('#courseReviewForm').find('button[type="submit"]').prop('disabled', true).text('Submitted');
                $('#courseReviewForm').off('submit');
            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                if(errors){
                    $.each(errors, function (key, value) {
                        toastr.error(value);
                    });
                } else {
                    toastr.error(xhr.responseJSON.message || 'Something went wrong');
                }
                $(this).find('button[type="submit"]').prop('disabled', false).text('Submit Review');
            }
        });
    });
});
